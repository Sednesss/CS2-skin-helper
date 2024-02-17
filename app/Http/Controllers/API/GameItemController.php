<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GameItem\StatusChangeRequest;
use App\Models\GameItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class GameItemController extends Controller
{
    public function statusChange(StatusChangeRequest $request)
    {
        try {
            $gameItem = GameItem::find($request->game_item_id);
            $gameItem->status = $request->status;
            $gameItem->save();

            return response()->json([
                'message' => 'Successfully changing the status of a game item',
            ], 200);
        } catch (\Throwable $th) {                                    
            $httpMethod = Route::current()->methods()[0];
            $routeName = Route::currentRouteName();
            Log::error("Error executing request: [$httpMethod] \"$routeName\": " . $th->getMessage());

            return response()->json([
                'message' => 'Failed to change the status of a game item',
            ], 500);
        }
    }
}
