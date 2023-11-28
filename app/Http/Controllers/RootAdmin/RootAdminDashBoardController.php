<?php

namespace App\Http\Controllers\RootAdmin;

use App\Constants\CurrentPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RootAdminDashBoardController extends Controller
{
    public function index()
    {
        return view('root_admin.dashboard', [
            'current_page' => CurrentPage::DASHBOARD,
        ]);
    }
}
