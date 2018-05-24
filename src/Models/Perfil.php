<?php
namespace Emimaster16\Autorizacion\Models;

use Emimaster16\Autorizacion\Traits\PermisoTrait;
use Illuminate\Database\Eloquent\Model;
use Config;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
class Perfil extends Model
{
    use PermissionTrait {
        flushPermissionCache as parentFlushPermissionCache;
    }

    /**
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'especial',
        'nombre',
        'url'
    ];

    /**
     *
     * @var string
     */
    protected $table = 'perfiles';

    /**
     *
     * @tutorial Method Description: La etiqueta de caché cxeducativa utilizada por el modelo.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @return string
     */
    public static function getShinobiTag()
    {
        return 'cxeducativa.perfiles';
    }

    /**
     * Roles can belong to many users.
     *
     * @return Model
     */
    public function usuarios()
    {
        return $this->belongsToMany(config('auth.model') ?  : config('auth.providers.users.model'))->withTimestamps();
    }

    /**
     * Get fresh permission slugs assigned to role from database.
     *
     * @return array
     */
    protected function getNuevosPermisos()
    {
        return $this->permissions->pluck('url')->all();
    }

    /**
     * Flush the permission cache repository.
     *
     * @return void
     */
    public function flushPermissionCache()
    {
        $userClass = config('auth.model') ?  : config('auth.providers.users.model');
        $usersTag = call_user_func([
            $userClass,
            'getAutorizacionTag'
        ]);
        static::parentFlushPermissionCache([
            static::getAutorizacionTag(),
            $usersTag
        ]);
    }

    /**
     * Checks if the role has the given permission.
     *
     * @param string $permission            
     *
     * @return bool
     */
    public function can($permission)
    {
        if ($this->special === 'no-access') {
            return false;
        }
        
        if ($this->special === 'all-access') {
            return true;
        }
        
        return $this->hasAllPermissions($permission, $this->getPermissions());
    }

    /**
     * Check if the role has at least one of the given permissions.
     *
     * @param array $permission            
     *
     * @return bool
     */
    public function canAtLeast(array $permission = [])
    {
        if ($this->special === 'no-access') {
            return false;
        }
        
        if ($this->special === 'all-access') {
            return true;
        }
        
        return $this->hasAnyPermission($permission, $this->getPermissions());
    }
}
