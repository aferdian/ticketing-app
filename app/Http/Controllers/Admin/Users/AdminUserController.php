<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\User;

class AdminUserController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('users');
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'users'=> $users,
        ]));
    }
}
