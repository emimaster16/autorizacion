<?php
namespace Cxeducativa\Autorizacion\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Closure;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
class UsuarioTienePermiso
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
     * @param string $permisos            
     * @return Ambigous <\Symfony\Component\HttpFoundation\Response, \Illuminate\Contracts\Routing\ResponseFactory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function handle($request, Closure $next, $permisos)
    {
        if ($this->auth->check()) {
            if (! $this->auth->user()->can($permisos)) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 403);
                }
                
                abort(403, 'Unauthorized action.');
            }
        } else {
            $guest = Role::whereSlug('guest')->first();
            
            if ($guest) {
                if (! $guest->can($permisos)) {
                    if ($request->ajax()) {
                        return response('Unauthorized.', 403);
                    }
                    
                    abort(403, 'Unauthorized action.');
                }
            }
        }
        
        return $next($request);
    }
}
