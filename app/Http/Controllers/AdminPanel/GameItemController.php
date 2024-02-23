<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\GameItem\StoreRequest;
use App\Http\Requests\AdminPanel\GameItem\UpdateRequest;
use App\Models\GameItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class GameItemController extends Controller
{
    public function index(): View
    {
        $itemsPerPage = 8;
        $gameItems = GameItem::withCount('skins')->paginate($itemsPerPage);
        $totalPages = $gameItems->lastPage();
        $currentPage = $gameItems->currentPage();

        $totalItems = $gameItems->total();
        $startItemNumber = $totalItems !== 0 ? $itemsPerPage * ($currentPage - 1) + 1: 0;
        $endItemNumber = min($startItemNumber + $itemsPerPage - 1, $totalItems);

        return view('admin_panel.game_items.index', [
            'gameItems' => $gameItems,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'totalItems' => $totalItems,
            'startItemNumber' => $startItemNumber,
            'endItemNumber' => $endItemNumber,
        ]);
    }

    public function create(): View
    {
        return view('admin_panel.game_items.create', []);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $gameItem = GameItem::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin_panel::game_items::show', $gameItem->id);
    }

    public function show(GameItem $gameItem): View
    {
        $gameItem = $gameItem->load('skins');

        $skinsItemsPerPage = 7;
        $skinsTotalItems = $gameItem->skins->count();
        $skinsStartItemNumber = $skinsTotalItems !== 0 ? 1: 0;
        $skinsEndItemNumber = min($skinsStartItemNumber + $skinsItemsPerPage - 1, $skinsTotalItems);
        $skinsTotalPages = ceil($skinsTotalItems / $skinsItemsPerPage);
        
        return view('admin_panel.game_items.show', [
            'gameItem' => $gameItem,
            'skinsTotalPages' => $skinsTotalPages,
            'skinsCurrentPage' => 1,
            'skinsItemsPerPage' => $skinsItemsPerPage,
            'skinsTotalItems' => $skinsTotalItems,
            'skinsStartItemNumber' => $skinsStartItemNumber,
            'skinsEndItemNumber' => $skinsEndItemNumber,
        ]);
    }

    public function edit(GameItem $gameItem): View
    {
        return view('admin_panel.game_items.edit', [
            'gameItem' => $gameItem,
        ]);
    }

    public function update(UpdateRequest $request, GameItem $gameItem): RedirectResponse
    {
        $gameItem->title = $request->title;
        $gameItem->description = $request->description;
        $gameItem->save();

        return redirect()->route('admin_panel::game_items::show', $gameItem->id);
    }

    public function destroy(GameItem $gameItem): RedirectResponse
    {
        $gameItem->delete();

        return redirect()->route('admin_panel::game_items::index');
    }
}
