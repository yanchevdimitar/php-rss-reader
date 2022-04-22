<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rss_id');
            $table->string('title')->nullable();;
            $table->string('source')->nullable();;
            $table->string('source_url')->nullable();;
            $table->string('link')->nullable();;
            $table->dateTime('publish_date')->nullable();;
            $table->text('description')->nullable();

            $table->foreign('rss_id')->references('id')->on('rsses')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feeds');
    }
}
