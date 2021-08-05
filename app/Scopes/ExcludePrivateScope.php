<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ExcludePrivateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Only show private threads owned by the current user
        if(!Auth::check()) {
            $builder->where('visibility_id', '<>', 3);
        } else {
            $builder->where(function($query) {
                $query->where('visibility_id', '<>', 3)
                ->orWhere(function($query) {
                    $query->where('visibility_id', 3)
                    ->where('user_id', auth()->user()->id);
                });
            });
        }
    }
}