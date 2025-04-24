<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserServices
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function createUser($data)
    {
        return $this->userRepository->createData($data);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function updateUser($id, $data)
    {
        return $this->userRepository->updateData($id, $data);
    }

    public function deleteUser($id)
    {
        // $user = User::findOrFail($id);
        return $this->userRepository->deleteData($id);
    }

    public function getAllUsers($perPage = 40, $selectRole = null, $search)
    {
        // $query = User::query();
        // if ($selectRole) {
        //     $query->whereHas('roles', function ($q) use ($selectRole) {
        //         $q->where('id', $selectRole);
        //     });
        // }

        // if ($search) {
        //     $query->where(function ($q) use ($search) {
        //         $q->where('name', 'like', '%' . $search . '%')
        //             ->orWhere('email', 'like', '%' . $search . '%');
        //     });
        // }

        $query = [
            "search" => $search,
            "search_columns" => ["name", "email"],
            "where_has" => [
                "roles" => [
                    ["id", "=", $selectRole]
                ]
            ]
        ];


        return $this->userRepository->paginateData($perPage, $query);
    }
}
