<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExcludeDeactivatedUser implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('account_status', '<>', 2);
    }
}