<?php

namespace App\Http\Controllers\AdminPanel;

use App\Exports\SkinExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Skin\StoreRequest;
use App\Models\GameItem;
use App\Models\Skin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SkinController extends Controller
{
    public function create(Request $request): View
    {
        $gameItem = null;
        $gameItems = null;
        $isForGameItem = false;

        $gameItemId = $request->query('game_item');

        if (!empty($gameItemId)) {
            $isForGameItem = true;
            $gameItem = GameItem::find($gameItemId);
        } else {
            $gameItems = GameItem::all();
        }

        return view('admin_panel.skins.create', [
            'isForGameItem' => $isForGameItem,
            'gameItem' => $gameItem,
            'gameItems' => $gameItems,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $skin = Skin::create([
            'game_item_id' => $request->game_item_id,
            'description' => $request->description ?? null,
            'pattern' => $request->pattern,
            'float' => $request->float,
        ]);

        return redirect()->route('admin_panel::game_items::show', $request->game_item_id);
    }

    public function export()
    {
        $fileName = 'import_skins_' . time() . '.xlsx';
        return Excel::download(new SkinExport, $fileName);
    }
}
