<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserServices
{
    public function createUser($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles' => 'required'
        ]);


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return User::create($validator->validated());
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',

            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $user = User::findOrFail($id);


        $user->update($validator->validated());
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function getAllUsers($perPage = 40, $selectRole = null,$search)
    {
        $query = User::query();
        if ($selectRole) {
            $query->whereHas('roles', function ($q) use ($selectRole) {
                $q->where('id', $selectRole);
            });
        }

         if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
      

        return $query->paginate($perPage);
    }
}
