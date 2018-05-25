<?php

namespace Cxeducativa\Autorizacion;

use Cxeducativa\Autorizacion\Models\Perfil;
use Illuminate\Contracts\Auth\Guard;

class Autorizacion
{
    /**
     * @var Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new UserHasPermission instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Checks if user has the given permissions.
     *
     * @param array|string $permisos
     *
     * @return bool
     */
    public function can($permisos)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->can($permisos);
        } else {
            $guest = Perfil::whereSlug('guest')->first();

            if ($guest) {
                return $guest->can($permisos);
            }
        }

        return false;
    }

    /**
     * Checks if user has at least one of the given permissions.
     *
     * @param array $permisos
     *
     * @return bool
     */
    public function canAtLeast($permisos)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->canAtLeast($permisos);
        } else {
            $guest = Perfil::whereSlug('guest')->first();

            if ($guest) {
                return $guest->canAtLeast($permisos);
            }
        }

        return false;
    }

    /**
     * Checks if user is assigned the given role.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function isPerfil($role)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->isRole($role);
        } else {
            if ($role === 'guest') {
                return true;
            }
        }

        return false;
    }
}
