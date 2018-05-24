<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class CreatePerfilUsuarioTable extends Migration
{

    /**
     *
     * @tutorial Method Description: ejecuta la migracion
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::create('perfil_usuario', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('id_perfil')
                ->unsigned()
                ->index();
            $table->foreign('id_perfil')
                ->references('id_perfil')
                ->on('perfiles')
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
        Schema::drop('perfil_usuario');
    }
}
