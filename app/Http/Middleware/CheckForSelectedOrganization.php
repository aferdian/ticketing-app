<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckForSelectedOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !session()->has('selected_organization_id')) {
            $userOrganizations = Auth::user()->organizations;

            if ($userOrganizations->count() > 1) {
                return redirect()->route('organization.select');
            } elseif ($userOrganizations->count() === 1) {
                session()->put('selected_organization_id', $userOrganizations->first()->id);
            }
        }

        return $next($request);
    }
}
