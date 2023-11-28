<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VRController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        return view('family_admin.vr_index', [
            'user' => $user,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }
}
