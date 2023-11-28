<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddRoleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Constants\UserType;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $admins = [
            UserType::FAMILY_ADMIN,
            UserType::FAMILY_SUB_ADMIN,
            UserType::SECRETARY,
        ];
        $familyTreeId = Auth::guard('family_member')->user()->family_tree_id;
        $users = User::select('id', 'full_name', 'type')
            ->where('family_tree_id', $familyTreeId)
            ->whereNotIn('type', $admins)
            ->get();
        $familyAdmins = User::select('id', 'full_name', 'type')
            ->where('family_tree_id', $familyTreeId)
            ->where('type', UserType::FAMILY_ADMIN)
            ->get();
        $subFamilyAdmins = User::select('id', 'full_name', 'type')
            ->where('family_tree_id', $familyTreeId)
            ->where('type', UserType::FAMILY_SUB_ADMIN)
            ->get();
        $secretaryAdmins = User::select('id', 'full_name', 'type')
            ->where('family_tree_id', $familyTreeId)
            ->where('type', UserType::SECRETARY)
            ->get();

        return view('family_admin.roles', [
            'current_page' => CurrentPage::ROLE,
            'users' => $users,
            'familyAdmins' => $familyAdmins,
            'subFamilyAdmins' => $subFamilyAdmins,
            'secretaryAdmins' => $secretaryAdmins,
        ]);
    }

    public function addRole(AddRoleRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->type = $request->type;
        $user->save();

        return redirect()->back();
    }

    public function removeRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->type = UserType::NORMAL;
        $user->save();

        return redirect()->back();
    }
}
