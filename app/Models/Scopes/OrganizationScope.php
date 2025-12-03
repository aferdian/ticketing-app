<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class OrganizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Bypass the scope if the authenticated user is a superadmin
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            return;
        }

        if (session()->has('selected_organization_id')) {
            $builder->where('organization_id', session('selected_organization_id'));
        }
    }
}
