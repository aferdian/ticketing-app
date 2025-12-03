<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('users');
        $user = Auth::user();

        $usersQuery = User::query();

        // If the user is not a superadmin, filter by the selected organization
        if ($user->role !== 'superadmin') {
            $selectedOrganizationId = session('selected_organization_id');
            $usersQuery->whereHas('organizations', function ($query) use ($selectedOrganizationId) {
                $query->where('organization_id', $selectedOrganizationId);
            });
        }

        $users = $usersQuery->with('organizations')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('layouts.admin.users', array_merge($viewData, [
            'users'=> $users,
        ]));
    }
}
