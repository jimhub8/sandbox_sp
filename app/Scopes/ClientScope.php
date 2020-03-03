<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClientScope implements Scope
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
        if (Auth::guard('clients')->check()) {
            $user = Auth::guard('clients')->user();
            return $builder->where('client_id', $user->id);
        } elseif (auth('api')->check()) {
            $user = auth('api')->user();
            return $builder->where('client_id', $user->id);
        }
    }
}
