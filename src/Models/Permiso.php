<?php
namespace Emimaster16\Autorizacion\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{

    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'nombre',
        'url',
    ];

    /**
     * 
     * @var string
     */
    protected $table = 'permisos';

    /**
     *
     * @tutorial Method Description: Permissions can belong to many roles.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @return Ambigous <\Illuminate\Database\Eloquent\Relations\BelongsToMany, \Illuminate\Database\Eloquent\Relations\Concerns\$this, \Illuminate\Database\Eloquent\Relations\BelongsToMany>
     */
    public function perfiles()
    {
        return $this->belongsToMany('\Emimaster16\Autorizacion\Models\Perfil')->withTimestamps();
    }

    /**
     *
     * @tutorial Method Description: Assigns the given role to the permission.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @param string $idPerfil            
     * @return void|boolean
     */
    public function asignarPerfil($idPerfil = null)
    {
        $perfiles = $this->perfiles;
        if (! $perfiles->contains($idPerfil)) {
            return $this->perfiles()->attach($idPerfil);
        }
        return false;
    }

    /**
     *
     * @tutorial Method Description: Revokes the given role from the permission.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @param string $roleId            
     */
    public function revocarPerfil($idPerfil = '')
    {
        return $this->perfiles()->detach($idPerfil);
    }

    /**
     *
     * @tutorial Method Description: sincroniza los perfiles dados con el permiso.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     * @param array $idsPerfil            
     */
    public function sincronizarPerfiles(array $idsPerfil = [])
    {
        return $this->perfiles()->sync($idsPerfil);
    }

    /**
     *
     * @tutorial Method Description: Revoca todas las funciones del permiso.
     * @author Eminson Mendoza ~~ emimaster16@gmail.com
     * @since {24/05/2018}
     */
    public function revocarPerfiles()
    {
        return $this->perfiles()->detach();
    }
}
