<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThematicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thematic_data', function (Blueprint $table) {
            $table->id('id');
            $table->string('code_thematic')->unique();
            $table->string('title_thematic')->unique();
            $table->foreignId('main_code')->references('code_main')->on('main_data')->onDelete('cascade');
            // $table->string('custom_id')->unique();
            $table->softDeletes();
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
        Schema::dropIfExists('thematic_data');
    }
}
