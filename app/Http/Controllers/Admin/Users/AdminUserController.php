<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends SuperAdminBaseController
{
    public function index()
    {
        $user = Auth::user();
        
        $viewData = $this->getViewData('users');
        $organizationIds = $user->organizations->pluck('id');
        $users = User::whereHas('organizations', function ($query) use ($organizationIds) {
            $query->whereIn('organization_id', $organizationIds);
        })
        ->with('organizations')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('layouts.admin.users', array_merge($viewData, [
            'users'=> $users,
        ]));
    }
}
