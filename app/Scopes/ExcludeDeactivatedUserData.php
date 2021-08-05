<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExcludeDeactivatedUserData implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Only show private threads owned by the current user
        $builder->whereHas('user', function ($query) {
            $query->where('account_status', '<>', 2);
        });
    }
}