<?php
namespace Emimaster16\Autorizacion\Traits;

/**
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
trait PermisoTrait
{

    /**
     * The shinobi cache tag used by the model.
     * Should be implemented by Model using this trait
     *
     * @return string
     */
    public static function getAutorizacionTag()
    {
        return '';
    }

    /**
     * Users and Roles can have many permissions
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function permisos()
    {
        return $this->belongsToMany('\Emimaster16\Autorizacion\Models\Permiso')->withTimestamps();
    }

    /**
     * Get fresh permission slugs assigned to the user or role.
     * Internal method, should be implemented by Model using this trait
     *
     * @return array
     */
    protected function getNuevosPermisos()
    {}

    /**
     * Wrapper for caching the permission slugs
     *
     * @return array
     */
    public function getPermisos()
    {
        $primaryKey = $this[$this->primaryKey];
        $cacheKey = 'cxeducativa.' . substr(static::getAutorizacionTag(), 0, - 1) . '.permisos.' . $primaryKey;
        
        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            return app()->make('cache')
                ->tags(static::getAutorizacionTag())
                ->remember($cacheKey, 60, function ()
            {
                return $this->getNuevosPermisos();
            });
        }
        
        return $this->getNuevosPermisos();
    }

    /**
     * Assigns the given permission to the user or role.
     *
     * @param int $idPermiso            
     *
     * @return bool
     */
    public function asignarPermiso($idPermiso = null)
    {
        $permisos = $this->permissions;
        
        if (! $permisos->contains($idPermiso)) {
            $this->flushPermissionCache();
            
            return $this->permissions()->attach($idPermiso);
        }
        
        return false;
    }

    /**
     * Revokes the given permission from the user or role.
     *
     * @param int $idPermiso            
     *
     * @return bool
     */
    public function revokePermission($idPermiso = '')
    {
        $this->flushPermissionCache();
        
        return $this->permissions()->detach($idPermiso);
    }

    /**
     * Syncs the given permission(s) with the user or role.
     *
     * @param array $idPermisos            
     *
     * @return bool
     */
    public function syncPermissions(array $idPermisos = [])
    {
        $this->flushPermissionCache();
        
        return $this->permissions()->sync($idPermisos);
    }

    /**
     * Revokes all permissions from the user or role.
     *
     * @return bool
     */
    public function revokeAllPermissions()
    {
        $this->flushPermissionCache();
        
        return $this->permissions()->detach();
    }

    /**
     * Flush the permission cache repository.
     *
     * @return void
     */
    public function flushPermisoCache(array $tags = null)
    {
        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            if ($tags === null) {
                $tags = [
                    static::getAutorizacionTag()
                ];
            }
            
            foreach ($tags as $tag) {
                app()->make('cache')
                    ->tags($tag)
                    ->flush();
            }
        }
    }

    /**
     * Check if the or all requested permissions are satisfied
     *
     * @param mixed $permiso            
     * @param array $permisos            
     *
     * @return bool
     */
    protected function hasAllPermisos($permiso, array $permisos)
    {
        if (is_array($permiso)) {
            $permisoCount = count($permiso);
            $intersection = array_intersect($permisos, $permiso);
            $intersectionCount = count($intersection);
            
            return ($permisoCount == $intersectionCount) ? true : false;
        } else {
            return in_array($permiso, $permisos);
        }
    }

    /**
     * Check if one of the requested permissions are satisfied
     *
     * @param array $permiso            
     * @param array $permisos            
     *
     * @return bool
     */
    protected function hasAnyPermiso(array $permiso, array $permisos)
    {
        $intersection = array_intersect($permisos, $permiso);
        $intersectionCount = count($intersection);
        
        return ($intersectionCount > 0) ? true : false;
    }
}
