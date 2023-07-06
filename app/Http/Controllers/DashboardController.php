<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $seminar = Seminar::all();
        $users = User::all();

        return view('admin.dashboard.index', compact('seminar', 'users'));
    }
}
