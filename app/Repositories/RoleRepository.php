<?php

namespace   App\Repositories;

use App\Utils\BaseCrudRepository;


class RoleRepository extends BaseCrudRepository
{
    protected array $creationRules = [
        'title' => 'required|string|max:255'
    ];

    protected array $updateRules = [
        'title' => 'required|string|max:255'
    ];
}
