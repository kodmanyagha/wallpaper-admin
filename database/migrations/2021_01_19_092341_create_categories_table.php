<?php

use App\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 128)->unique();
            $table->string('title', 512)->nullable();

            $table->boolean('active')->default(true);

            cts($table);
        });

        $save        = new Category();
        $save->slug  = 'space';
        $save->title = 'Uzay (Space)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'road';
        $save->title = 'Yol (Road)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'earth';
        $save->title = 'Dünya (Earth)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'mars';
        $save->title = 'Mars (Mars)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'abstract';
        $save->title = 'Soyut (Abstract)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'technology';
        $save->title = 'Teknoloji (Technology)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'travel';
        $save->title = 'Gezi, Seyahat (Travel)';
        $save->save();

        $save        = new Category();
        $save->slug  = 'osx';
        $save->title = 'Apple Mac';
        $save->save();

        $save        = new Category();
        $save->slug  = 'iphone';
        $save->title = 'iPhone';
        $save->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
