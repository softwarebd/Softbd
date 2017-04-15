<?php

namespace SBD\Softbd\Traits;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use SBD\Softbd\Facades\Softbd;
use SBD\Softbd\Models\Role;

/**
 * @property  \Illuminate\Database\Eloquent\Collection  roles
 */
trait SoftbdUser
{
    public function role()
    {
        return $this->belongsTo(Softbd::modelClass('Role'));
    }

    /**
     * Check if User has a Role(s) associated.
     *
     * @param string|array $name The role to check.
     *
     * @return bool
     */
    public function hasRole($name)
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return in_array($this->role->name, (is_array($name) ? $name : [$name]));
    }

    public function setRole($name)
    {
        $role = Softbd::model('Role')->where('name', '=', $name)->first();

        if ($role) {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

    public function hasPermission($name)
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return in_array($name, $this->role->permissions->pluck('key')->toArray());
    }

    public function hasPermissionOrFail($name)
    {
        if (!$this->hasPermission($name)) {
            throw new UnauthorizedHttpException(null);
        }

        return true;
    }

    public function hasPermissionOrAbort($name, $statusCode = 403)
    {
        if (!$this->hasPermission($name)) {
            return abort($statusCode);
        }

        return true;
    }
}
