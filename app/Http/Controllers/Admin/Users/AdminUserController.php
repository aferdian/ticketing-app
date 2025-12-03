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
            $usersQuery->join('user_organization', 'users.id', '=', 'user_organization.user_id')
                ->where('user_organization.organization_id', $selectedOrganizationId)
                ->select('users.*', 'user_organization.organization_role', 'user_organization.created_at as joined_at'); // Select all user columns, pivot role, and pivot created_at as joined_at
        }

        $users = $usersQuery->with(['organizations' => function ($query) {
            $query->where('id', session('selected_organization_id'))->withPivot('organization_role');
        }])
            ->orderByRaw("FIELD(user_organization.organization_role, 'owner', 'admin', 'product_manager', 'order_manager', 'checkin_staff')")
            ->orderBy('users.created_at', 'desc') // Specify table for created_at
            ->paginate(10);

        return view('layouts.admin.users', array_merge($viewData, [
            'users'=> $users,
        ]));
    }
}
