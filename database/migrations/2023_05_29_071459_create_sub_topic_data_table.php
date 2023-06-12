<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubTopicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_topic_data', function (Blueprint $table) {
            $table->id();
            $table->string('code_subtopic');
            $table->string('indikator_kinerja_utama');
            $table->string('formula');
            $table->string('topic_code');
            $table->foreign('topic_code')->references('code_topic')->on('topic_data')->onDelete('cascade');
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
        Schema::dropIfExists('sub_topic_data');
    }
}
