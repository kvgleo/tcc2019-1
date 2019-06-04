<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('topicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('artigo');
            $table->string('top_titulo');
            $table->string('author');
            $table->boolean('admin_post');
            $table->bigInteger('id_cat')->unsigned();
            $table->foreign('id_cat')->references('id')->on('categorias');
            $table->integer('top_views');
            $table->boolean('status_top');
            $table->integer('votos');
            $table->integer('comentarios');
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
        Schema::dropIfExists('topicos');
    }
}