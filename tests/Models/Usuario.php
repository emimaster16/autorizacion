<?php
namespace Emimaster16\Autorizacion\Tests\Models;

use Emimaster16\Autorizacion\Traits\AutorizacionTrait;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use AutorizacionTrait;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];
}