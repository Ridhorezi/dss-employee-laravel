<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $topEmployees = Employee::orderBy('value', 'desc')->limit(3)->get();

        return view('pages.dashboard', compact('topEmployees'));
    }

    public function home()
    {
        return view('pages.home');
    }
}