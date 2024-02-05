<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\GameItem;
use App\Models\Skin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $gameItemsCount = GameItem::count();
        $skinsCount = Skin::count();

        return view('admin_panel.dashboards.index', [
            'gameItemsCount' => $gameItemsCount,
            'skinsCount' => $skinsCount
        ]);
    }
}
