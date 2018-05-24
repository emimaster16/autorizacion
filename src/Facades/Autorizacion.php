<?php
namespace Emimaster16\Autorizacion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {23/05/2018}
 */
class Autorizacion extends Facade
{

    /**
     *
     * @tutorial Method Description: Obtenga el nombre registrado del componente.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {23/05/2018}
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'autorizacion';
    }
}
