<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class CreatePerfilesTable extends Migration
{

    /**
     *
     * @tutorial Method Description: ejecuta la migracion
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::create('perfiles', function (Blueprint $table)
        {
            $table->increments('id_perfil');
            $table->string('nombre')->unique();
            $table->string('url')->unique();
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_registro');
            $table->timestamp('fecha_modificacion')->nullable();
        });
    }

    /**
     *
     * @tutorial Method Description: revoca la migracion
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function down()
    {
        Schema::drop('perfiles');
    }
}
