<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @method void middleware(string|array $middleware, array $options = [])
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // For citizens, show their reports; for admins, redirect to admin dashboard.
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('reports.index');
    }
}