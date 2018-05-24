<?php
namespace Emimaster16\Autorizacion\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Closure;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
class UsuarioTienePerfil
{

    /**
     *
     * @var Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     *
     * @tutorial Method Description: Create a new UserHasPermission instance.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @param Guard $auth            
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     *
     * @tutorial Method Description: Run the request filter.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @param Request $request            
     * @param Closure $next            
     * @param string $perfil            
     * @return Ambigous <\Symfony\Component\HttpFoundation\Response, \Illuminate\Contracts\Routing\ResponseFactory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>|void
     */
    public function handle($request, Closure $next, $perfil)
    {
        if (! $this->auth->user()->isRole($perfil)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            
            return abort(401);
        }
        
        return $next($request);
    }
}
