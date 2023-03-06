<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasets', function (Blueprint $table) {
            $table->id('datasetId');
            $table->string('title');
            $table->string('name_excel');
            $table->string('description');
            // $table->foreignId('id_variable')->references('varId')->on('variables')->onDelete('cascade');
            // $table->foreignId('id_value')->references('valueId')->on('values')->onDelete('cascade');
            // $table->file    
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
        Schema::dropIfExists('datasets');
    }
}
