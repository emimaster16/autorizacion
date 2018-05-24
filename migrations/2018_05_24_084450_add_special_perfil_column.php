<?php
use Illuminate\Database\Migrations\Migration;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class AddSpecialPerfilColumn extends Migration
{

    /**
     *
     * @tutorial Method Description: ejecuta la migracion
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     */
    public function up()
    {
        Schema::table('perfiles', function ($table)
        {
            $table->enum('especial', [
                'all-access',
                'no-access'
            ])->nullable();
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
        Schema::table('perfiles', function ($table)
        {
            $table->dropColumn('especial');
        });
    }
}
