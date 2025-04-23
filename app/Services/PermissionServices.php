<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PermissionServices
{
    public function createPermission($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return Permission::create($validator->validated());
    }

    public function getPermissionById($id)
    {
        return Permission::findOrFail($id);
    }

    public function updatePermission($id, $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $permission = Permission::findOrFail($id);
        return $permission->update($validator->validated());
    }

    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        return $permission->delete();
    }

    public function getPaginatedPermissions($perPage = 40 ,$search)
    {
        // return Permission::paginate($perPage);
        $query = Permission::query();
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }
        return $query->paginate($perPage);
    }
}
