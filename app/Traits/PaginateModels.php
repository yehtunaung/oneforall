<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

trait PaginateModels
{

    public function getPaginatedResults(
        Model $modelClass,
        int $perPage = 20,
        array $options = []
    ): LengthAwarePaginator {

        $query = $modelClass::query();

        // Eager Loading
        if (!empty($options["with"])) $query->with($options["with"]);

        // search query
        if ((!empty($options["search"]))) {
            $searchTerm = $options["search"];
            $searchColumns = $options["search_columns"] ?? ["id"];

            $query->where(function ($q) use ($searchTerm, $searchColumns) {
                foreach ((array) $searchColumns as $column) {
                    $q->orWhere($column, 'like', "%{$searchTerm}%");
                }
            });
        }

        // where has condition for relation filtering
        if (!empty($options["where_has"])) {
            foreach ($options["where_has"] as $relation => $conditions) {
                $query->whereHas($relation, function ($q) use ($conditions) {
                    foreach ($conditions as $condition) {
                        [$column, $operator, $value] = $condition;
                       if(!empty($value)) $q->where($column, $operator, $value);
                    }
                });
            }
        }

        // Custom query
        if (!empty($options["custom_query"])) {
            $options["custom_query"]($query);
        }

        return $query->paginate($perPage);
    }
}
