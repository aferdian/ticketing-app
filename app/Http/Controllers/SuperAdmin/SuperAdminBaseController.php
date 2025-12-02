<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminBaseController extends Controller
{
    protected function getViewData($activeContent){
        $userOrganizations = Auth::user()->organizations;
        if (count($userOrganizations) > 0) {
            if (empty(session('selected_organization_id'))) {
                // set default organization
                session()->put('selected_organization_id', $userOrganizations[0]->id);
            }
        }

        return [
            'activeContent' => $activeContent,
            'user' =>Auth::user(),
        ];
    }
}
