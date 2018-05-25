<?php
namespace Cxeducativa\Autorizacion\Traits;

use Cxeducativa\Autorizacion\Models\Perfil;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
trait AutorizacionTrait
{
    use PermisoTrait;

    /**
     * The shinobi cache tag used by the user model.
     *
     * @return string
     */
    public static function getAutorizacionTag()
    {
        return 'autorizacion.usuarios';
    }

    /**
     * Users can have many perfiles.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function perfiles()
    {
        return $this->belongsToMany('\Cxeducativa\Autorizacion\Models\Perfil')->withTimestamps();
    }

    /**
     * Get all user perfiles.
     *
     * @return array|null
     */
    public function getPerfiles()
    {
        if (! is_null($this->perfiles)) {
            return $this->perfiles->pluck('url')->all();
        }
    }

    /**
     * Checks if the user has the given role.
     *
     * @param string $url            
     *
     * @return bool
     */
    public function isPerfil($url)
    {
        $url = strtolower($url);
        
        foreach ($this->perfiles as $role) {
            if ($role->url == $url) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Assigns the given role to the user.
     *
     * @param int $idPerfil            
     *
     * @return bool
     */
    public function asignarPerfil($idPerfil = null)
    {
        $this->flushPermisoCache();
        if (! is_numeric($idPerfil)) {
            $idPerfil = Perfil::where('url', $idPerfil)->pluck('id_perfil')->first();
        }
        $perfiles = $this->perfiles;
        if (! $perfiles->contains($idPerfil)) {
            return $this->perfiles()->attach($idPerfil);
        }
        return false;
    }

    /**
     * Revokes the given role from the user.
     *
     * @param int $idPerfil            
     *
     * @return bool
     */
    public function revocarPerfil($idPerfil = '')
    {
        $this->flushPermisoCache();
        
        if (! is_numeric($idPerfil)) {
            $idPerfil = Perfil::where('url', $idPerfil)->pluck('id_perfil')->first();
        }
        
        return $this->perfiles()->detach($idPerfil);
    }

    /**
     * Syncs the given role(s) with the user.
     *
     * @param array $idPerfiles            
     *
     * @return bool
     */
    public function sincronizarPerfiles(array $idPerfiles)
    {
        $this->flushPermisoCache();
        
        return $this->perfiles()->sync($idPerfiles);
    }

    /**
     * Revokes all perfiles from the user.
     *
     * @return bool
     */
    public function revocarPerfiles()
    {
        $this->flushPermisoCache();
        
        return $this->perfiles()->detach();
    }
    
    /*
     * |----------------------------------------------------------------------
     * | Permiso Trait Methods
     * |----------------------------------------------------------------------
     * |
     */
    
    /**
     * Get Permiso slugs assigned to user.
     *
     * @return array
     */
    public function getUsuarioPermisos()
    {
        return $this->permisos->pluck('url')->all();
    }

    /**
     * Get all user role permisos fresh from database
     *
     * @return array|null
     */
    protected function getNuevosPermisos()
    {
        $permisos = [
            [],
            $this->getUsuarioPermisos()
        ];
        
        foreach ($this->perfiles as $perfil) {
            $permisos[] = $perfil->getPermisos();
        }
        
        return call_user_func_array('array_merge', $permisos);
    }

    /**
     * Check if user has the given Permiso.
     *
     * @param string $permiso            
     * @param array $arguments            
     *
     * @return bool
     */
    public function can($permiso, $arguments = [])
    {
        foreach ($this->perfiles as $role) {
            if ($role->especial === 'sin-acceso') {
                return false;
            }
            
            if ($role->especial === 'acceso-total') {
                return true;
            }
        }
        
        return $this->hasAllPermisos($permiso, $this->getPermisos());
    }

    /**
     * Check if user has at least one of the given Permisos.
     *
     * @param array $permisos            
     *
     * @return bool
     */
    public function canAtLeast(array $permisos)
    {
        foreach ($this->perfiles as $role) {
            if ($role->especial === 'sin-acceso') {
                return false;
            }
            
            if ($role->especial === 'acceso-total') {
                return true;
            }
            
            if ($role->canAtLeast($permisos)) {
                return true;
            }
        }
        
        return false;
    }
    
    /*
     * |----------------------------------------------------------------------
     * | Magic Methods
     * |----------------------------------------------------------------------
     * |
     */
    
    /**
     * Magic __call method to handle dynamic methods.
     *
     * @param string $method            
     * @param array $arguments            
     *
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        // Handle isRoleslug() methods
        if (starts_with($method, 'is') and $method !== 'is') {
            $role = kebab_case(substr($method, 2));
            
            return $this->isRole($role);
        }
        
        // Handle canDoSomething() methods
        if (starts_with($method, 'can') and $method !== 'can') {
            $permiso = kebab_case(substr($method, 3));
            
            return $this->can($permiso);
        }
        
        return parent::__call($method, $arguments);
    }
}
