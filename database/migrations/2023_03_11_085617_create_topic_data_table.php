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
            $table->integer('code_topic');
            $table->string('indicator')->unique();
            $table->string('formula')->unique();
            // $table->foreignId('code_thematic')->references('code_thematic')->on('thematic_data')->onDelete('cascade');
            $table->foreignId('code_thematic')->on('thematic_data')->onDelete('cascade');
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
