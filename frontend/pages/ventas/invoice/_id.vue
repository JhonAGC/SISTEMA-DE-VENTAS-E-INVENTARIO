<template>
  <div>
    <JcLoader :load="load" />
    <AdminTemplate :page="page" :modulo="modulo">
      <template #body>
        <div class="row justify-content-md-center">
          <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
              <div class="card-header p-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6>Detalle de venta</h6>
                    <p class="text-sm mb-0">
                      Venta no. <b>{{ model.id }}</b> de
                      <b>{{ model.fecha }}</b>
                    </p>
                  </div>
                  <button
                    @click="$router.back()"
                    class="btn bg-gradient-info btn-sm mb-0"
                  >
                    <i class="ni ni-bold-left"></i> Regresar
                  </button>
                </div>
              </div>
              <div class="card-body p-3 pt-0">
                <hr class="horizontal dark mt-0 mb-4" />
                <div class="row">
                  <div
                    class="col-12"
                    v-for="m in model.venta_inventarios"
                    :key="m.id"
                  >
                    <div class="d-flex">
                      <div>
                        <h6 class="text-lg mb-0 mt-2">
                          {{ m.inventario?.articulo?.nombre }}
                        </h6>
                        <p class="text-sm mb-3">
                          {{ Number(m.precio).toFixed(2) }} x {{ m.cantidad }}
                          {{ m.inventario?.articulo?.medida?.codigo }}
                        </p>
                        <span class="badge badge-sm bg-gradient-success">
                          <i class="fas fa-barcode"></i>
                          {{ m.inventario?.articulo?.barra }}
                        </span>
                        <span class="badge badge-sm bg-gradient-info">
                          {{ m.inventario?.articulo?.categoria?.nombre }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="horizontal dark mt-4 mb-4" />
                <div class="row">
                  <div class="col-lg-8 col-md-6 col-12">
                    <h6 class="mb-3 mt-4">Información</h6>
                    <ul class="list-group">
                      <li
                        class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg"
                      >
                        <div class="d-flex flex-column">
                          <h6 class="mb-3 text-sm">Detalle de venta</h6>

                          <span class="mb-2 text-xs">
                            Cliente:
                            <span
                              v-if="model.cliente"
                              class="text-dark font-weight-bold ms-2"
                            >
                              {{ model.cliente.nombre }}
                              {{ model.cliente.apePaterno }}
                              {{ model.cliente.apeMaterno }}
                            </span>
                            <span
                              v-else
                              class="text-dark font-weight-bold ms-2"
                            >
                              N/A
                            </span>
                          </span>
                          <!-- dato2 -->
                          <span class="mb-2 text-xs">
                            Usuario:
                            <span
                              v-if="model.user"
                              class="text-dark font-weight-bold ms-2"
                            >
                              {{ model.user.nombre }}
                            </span>
                            <span
                              v-else
                              class="text-dark font-weight-bold ms-2"
                            >
                              N/A
                            </span>
                          </span>
                          <!-- cliente 3 -->
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12 ms-auto">
                    <div class="d-flex justify-content-between mt-4">
                      <span class="mb-2 text-lg"> Total: </span>
                      <span class="text-dark text-lg ms-2 font-weight-bold">
                        {{ Number(model.total).toFixed(2) }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </AdminTemplate>
  </div>
</template>

<script>
export default {
  name: "IndexPage",
  head() {
    return {
      title: this.modulo,
    };
  },
  data() {
    return {
      load: true,
      model: {
        id: null,
        fecha: null,
        cliente: [],
        usuario: [],
        total: 0,
        venta_inventarios: [],
      },
      apiUrl: "ventas",
      page: "Ventas",
      modulo: "Invoice",
    };
  },
  methods: {
    async GET_DATA(path) {
      try {
        const res = await this.$api.$get(path);
        return res;
      } catch (error) {
        console.error("Error fetching data:", error);
        return null;
      }
    },
  },
  async mounted() {
    this.load = true;
    try {
      const data = await this.GET_DATA("ventas/" + this.$route.params.id);
      if (data) {
        this.model = data;
      }
    } catch (e) {
      console.error(e);
    } finally {
      this.load = false;
    }
  },
};
</script>
