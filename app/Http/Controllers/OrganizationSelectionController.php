<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrganizationSelectionController extends Controller
{
    public function showSelectionForm()
    {
        $userOrganizations = Auth::user()->organizations;
        return view('auth.select-organization', compact('userOrganizations'));
    }

    public function processSelection(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $user = Auth::user();
        if (!$user->organizations->contains($request->organization_id)) {
            return back()->withErrors(['organization_id' => 'You do not have access to this organization.']);
        }

        session()->put('selected_organization_id', $request->organization_id);

        return redirect()->intended('/admin'); // Redirect to the intended URL or a default dashboard
    }

    public function changeOrganization(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $user = Auth::user();
        if (!$user->organizations->contains($request->organization_id)) {
            return back()->withErrors(['organization_id' => 'You do not have access to this organization.']);
        }

        session()->put('selected_organization_id', $request->organization_id);

        return back();
    }
}
