<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class CreatePermisosTable extends Migration
{

    /**
     *
     * @tutorial Method Description: ejecuta la migration para crear la tabla
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table)
        {
            $table->increments('id_permiso');
            $table->string('nombre');
            $table->string('url')->unique();
            $table->text('id_menu')->nullable();
            $table->foreign('id_menu')
                ->references('menus')
                ->on('menus')
                ->onDelete('cascade');
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
        Schema::drop('permisos');
    }
}
