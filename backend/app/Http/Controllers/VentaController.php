<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Venta;
use App\Models\CajaVenta;
use App\Models\VentaInventario;
use App\Models\Inventario;
use App\Models\Sucursal;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Metodo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $ventas = Venta::where('estado', 1)->get();
        $list = [];
        foreach ($ventas as $m) {

            $list[] = $this->show($m);
        }
        return $list;



        // Implementar filtros de búsqueda adicionales si es necesario
        // Ejemplo: filtrar por rango de fechas
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $ventas->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        // Paginación (opcional)
        if ($request->has('per_page')) {
            $ventas = $ventas->paginate($request->per_page);
        } else {
            $ventas = $ventas->get();
        }

        foreach ($ventas as $venta) {
            $venta->url_pdf = url('api/reportes/ventas/' . $venta->id);
        }

        return $ventas;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venta = new Venta();
        $venta->cliente_id = $request->cliente_id;
        $venta->user_id = $request->user_id;
        $venta->total = $request->total;
        $venta->pago = $request->pago;
        $venta->cambio = $request->cambio;
        $venta->metodo_id = $request->metodo_id;
        $venta->tipo = $request->tipo;

        /* $venta->motivo = $request->motivo; */
        $venta->save();
        $numero = Venta::all()->count() + 1;
        if (isset($request->carrito)) {
            if (!empty($request->carrito)) {
                foreach ($request->carrito as $m) {
                    $articulo = $m['articulo'];
                    $inventario = new Inventario();
                    $inventario->articulo_id = $articulo['id'];
                    $inventario->tipo = 2;
                    $inventario->compra = $articulo['compra'];
                    $inventario->venta = $articulo['venta'];
                    $inventario->cantidad = $m['cantidad'];
                    $inventario->motivo = "Venta #" . $numero;
                    $inventario->save();
                    $ventaInventario = new VentaInventario();
                    $ventaInventario->inventario_id = $inventario->id;
                    $ventaInventario->venta_id = $venta->id;
                    $ventaInventario->cantidad = $m['cantidad'];
                    $ventaInventario->precio = $m['precio'];
                    $ventaInventario->save();
                }
            }
        }
        if (isset($request->caja_id)) {
            $cajaVenta = new CajaVenta();
            $cajaVenta->caja_id = $request->caja_id;
            $cajaVenta->venta_id = $venta->id;
            $cajaVenta->monto = $venta->total;
            $cajaVenta->save();
        }
        return $this->show($venta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {

        $venta->load('cliente', 'user', 'metodo');
        $venta->venta_inventarios = $venta->VentaInventarios()->with(['Inventario' => function ($i) {
            $i->with(['Articulo' => function ($a) {
                $a->with(['Marca', 'Categoria', 'Medida']);
            }]);
        }])->get();


        $venta->fecha = $venta->created_at->format('Y-m-d');
        $venta->url_pdf = url('api/reportes/ventas/' . $venta->id);
        return $venta;
    }
    public function pdf(Venta $venta)
    {
        $sucursal = Sucursal::all()->first();
        $boleta = Boleta::where('venta_id', $venta->id)->get();
        $factura = Factura::where('venta_id', $venta->id)->get();


        $venta = $this->show($venta);
        $venta->sucursal = $sucursal;
        $venta->boleta = $boleta;
        $venta->factura = $factura;
        $pdf = PDF::loadView('reports.venta', ["venta" => $venta]);
        return $pdf->stream();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        $venta->estado = 0;
        $venta->save();
        $venta->caja_venta = $venta->CajaVenta;
        $venta->caja_venta->estado = 0;
        $venta->caja_venta->save();
    }
}
