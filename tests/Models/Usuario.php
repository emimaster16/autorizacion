<?php
namespace Cxeducativa\Autorizacion\Tests\Models;

use Cxeducativa\Autorizacion\Traits\AutorizacionTrait;
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