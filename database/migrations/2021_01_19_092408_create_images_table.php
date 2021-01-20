<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('photographer_id')->index();
            $table->unsignedBigInteger('remote_id')->index();

            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('width')->nullable();

            $table->string('avg_color', 8);
            $table->string('url', 512)->nullable();
            $table->string('original_url', 512);
            $table->string('tiny_url', 512);

            cts($table);

            // foreign keys
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('photographer_id')->references('id')->on('photographers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
