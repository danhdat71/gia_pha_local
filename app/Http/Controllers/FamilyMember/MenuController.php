<?php

namespace App\Http\Controllers\FamilyMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class MenuController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        return view('family_member.mobile.menu', [
            'agent' => $agent,
        ]);
    }
}
