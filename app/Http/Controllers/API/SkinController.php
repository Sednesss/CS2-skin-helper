<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Skin\DestroyRequest;
use App\Http\Requests\API\Skin\PaginationRequest;
use App\Models\Skin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class SkinController extends Controller
{
    public function pagination(PaginationRequest $request)
    {
        try {
            $itemsPerPage = 7;
            $currentPage = $request->page ?? 1;

            $skins = Skin::where('game_item_id', $request->game_item_id)
                ->offset(($currentPage - 1) * $itemsPerPage)
                ->limit($itemsPerPage)
                ->get();

            $totalItems = Skin::where('game_item_id', $request->game_item_id)->count();
            $startItemNumber = $totalItems !== 0 ? $itemsPerPage * ($currentPage - 1) + 1: 0;
            $endItemNumber = min($startItemNumber + $itemsPerPage - 1, $totalItems);
            $totalPages = ceil($totalItems / $itemsPerPage);

            return response()->json([
                'message' => 'Successfully receiving skin pagination elements',
                'data' => [
                    'skins' => $skins,
                    'totalPages' => $totalPages,
                    'totalItems' => $totalItems,
                    'startItemNumber' => $startItemNumber,
                    'endItemNumber' => $endItemNumber,
                    'itemsPerPage' => $itemsPerPage,
                ]
            ], 200);
        } catch (\Throwable $th) {
            $httpMethod = Route::current()->methods()[0];
            $routeName = Route::currentRouteName();
            Log::error("Error executing request: [$httpMethod] \"$routeName\": " . $th->getMessage());

            return response()->json([
                'message' => 'Failed to receive skin pagination elements',
            ], 500);
        }
    }

    public function destroy(DestroyRequest $request)
    {
        try {
            $skin = Skin::find($request->skin_id);
            $skin->delete();

            return response()->json([
                'message' => 'Successful skin removal',
            ], 200);
        } catch (\Throwable $th) {
            $httpMethod = Route::current()->methods()[0];
            $routeName = Route::currentRouteName();
            Log::error("Error executing request: [$httpMethod] \"$routeName\": " . $th->getMessage());

            return response()->json([
                'message' => 'Failed to skin removal',
            ], 500);
        }
    }
}
