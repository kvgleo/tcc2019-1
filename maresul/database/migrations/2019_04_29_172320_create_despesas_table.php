<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('desp_pes', 8, 2);
            $table->decimal('desp_conc', 8, 2);
            $table->decimal('desp_ccmi', 8, 2);
            $table->decimal('desp_adm', 8, 2);
            $table->decimal('fundo_renda', 8, 2);
            $table->decimal('desp_as', 8, 2);
            $table->longText('ps');
            $table->date('reportdate');
            $table->string('author');
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
        Schema::dropIfExists('despesas');
    }
}
