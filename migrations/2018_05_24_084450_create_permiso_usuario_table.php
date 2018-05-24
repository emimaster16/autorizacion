<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class CreatePermissionUserTable extends Migration
{

    /**
     *
     * @tutorial Method Description: ejecuta la migracion
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::create('permiso_usuario', function (Blueprint $table)
        {
            $table->increments('id_permiso_usuario');
            $table->integer('id_permiso')
                ->unsigned()
                ->index();
            $table->foreign('id_permiso')
                ->references('id_permiso')
                ->on('permisos')
                ->onDelete('cascade');
            $table->integer('id_usuario')
                ->unsigned()
                ->index();
            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
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
        Schema::drop('permiso_usuario');
    }
}
