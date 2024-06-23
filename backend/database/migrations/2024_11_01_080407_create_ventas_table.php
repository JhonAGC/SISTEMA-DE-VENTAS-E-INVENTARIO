<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');

            $table->foreignId('metodo_id')
                ->nullable()
                ->constrained('metodos');

            $table->decimal('total', 8, 2)->default(0);
            $table->decimal('pago', 8, 2)->default(0);
            $table->decimal('cambio', 8, 2)->default(0);
            $table->char('tipo', 1)->default('B');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
