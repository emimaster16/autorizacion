<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class CreatePerfilPermisoTable extends Migration
{

    /**
     *
     * @tutorial Method Description: crea la tabla para relacionar los permisos con el perfil
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::create('perfil_permiso', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('id_permiso')
                ->unsigned()
                ->index();
            $table->foreign('id_permiso')
                ->references('permisos')
                ->on('permisos')
                ->onDelete('cascade');
            $table->integer('id_perfil')
                ->unsigned()
                ->index();
            $table->foreign('id_perfil')
                ->references('perfiles')
                ->on('perfiles')
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
        Schema::drop('perfil_permiso');
    }
}
