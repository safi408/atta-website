<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class DashboardController extends Controller
{
    //
        public function index()
    {
        $items = Expense::orderBy('date', 'desc')->get();
       return view('Backend.admin.dashboard', compact('items'));
    }
}
