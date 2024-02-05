<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $lotsCount = Lot::count();
        return view('admin_panel.dashboards.index', [
            'lotsCount' => $lotsCount
        ]);
    }
}
