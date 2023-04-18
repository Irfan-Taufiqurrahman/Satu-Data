<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_data', function (Blueprint $table) {
            $table->id('id');
            $table->string('code_topic')->unique();
            $table->string('kinerja_utama');
            $table->string('sumber_data');
            $table->string('penanggungjawab');
            $table->string('thematic_code');
            // $table->foreignId('code_thematic')->references('code_thematic')->on('thematic_data')->onDelete('cascade');
            // $table->string('thematic_code')->on('thematic_data')->onDelete('cascade');
            $table->foreign('thematic_code')->references('code_thematic')->on('thematic_data')->onDelete('cascade');
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
        Schema::dropIfExists('topic_data');
    }
}
