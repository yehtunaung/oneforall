<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleServices
{
    public function createRole($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return Role::create($validator->validated());
    }

    public function getRoleById($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function updateRole($id, $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $permission = Role::with('permissions')->findOrFail($id);
        $permission->update($validator->validated());
        return $permission;
    }

    public function deleteRole($id)
    {
        $permission = Role::with('permissions')->findOrFail($id);
        return $permission->delete();
    }
    public function getPaginatedRole($perPage = 5, $search)
    {

        $query = Role::query();
        // dd($query);
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }
        return $query->paginate($perPage);
    }
}
