<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Theme;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('filename');
        });
        
        Schema::table('users', function($table)
        {
            $table->string('theme_id')->default(1);
            $table->foreign('theme_id')->references('id')->on('themes');
        });
      
        Theme::create([ 'id' => 1, 'name' => 'Cosmo', 'filename' => 'cosmo.min.css' ]); //default
        Theme::create([ 'name' => 'Cerulean', 'filename' => 'cerulean.min.css' ]);
        Theme::create([ 'name' => 'Darkly', 'filename' => 'darkly.min.css' ]);
        Theme::create([ 'name' => 'Flatly', 'filename' => 'flatly.min.css' ]);
        Theme::create([ 'name' => 'Lumen', 'filename' => 'lumen.min.css' ]);
        Theme::create([ 'name' => 'Paper', 'filename' => 'paper.min.css' ]);
        Theme::create([ 'name' => 'Readable', 'filename' => 'readable.min.css' ]);
        Theme::create([ 'name' => 'Sandstone', 'filename' => 'sandstone.min.css' ]);
        Theme::create([ 'name' => 'Simplex', 'filename' => 'simplex.min.css' ]);
        Theme::create([ 'name' => 'Superhero', 'filename' => 'superhero.min.css' ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropForeign('users_theme_id_foreign');
            $table->dropColumn('theme_id');
        });

        Schema::drop('themes');
    }
}
