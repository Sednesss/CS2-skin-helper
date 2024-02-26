<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Skin\DestroyRequest;
use App\Http\Requests\API\Skin\ImportRequest;
use App\Http\Requests\API\Skin\PaginationRequest;
use App\Http\Requests\API\Skin\UpdateRequest;
use App\Imports\SkinImport;
use App\Models\Skin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    public function update(UpdateRequest $request)
    {
        try {
            $skin = Skin::find($request->skin_id);
            $skin->pattern = $request->pattern;
            $skin->float = $request->float;
            $skin->save();

            return response()->json([
                'message' => 'Successful skin update',
            ], 200);
        } catch (\Throwable $th) {
            $httpMethod = Route::current()->methods()[0];
            $routeName = Route::currentRouteName();
            Log::error("Error executing request: [$httpMethod] \"$routeName\": " . $th->getMessage());

            return response()->json([
                'message' => 'Failed to skin update',
            ], 500);
        }
    }

    public function import(ImportRequest $request)
    {
        try {

            if ($request->type == 'rewrite') {
                Skin::where('game_item_id', $request->game_item_id)->delete();
            }

            $file = $request->file('file');
            $OriginalfileName = $file->getClientOriginalName();
            $OriginalfileExtension = pathinfo($OriginalfileName, PATHINFO_EXTENSION);

            $fileName = md5(uniqid() . time()) . '.' . $OriginalfileExtension;
            $filePath = 'skins/import/' . $fileName;
            Storage::disk('local')->put($filePath, file_get_contents($file));

            Excel::import(new SkinImport($request->game_item_id), $filePath);

            Storage::disk('local')->delete($filePath);
            
            return response()->json([
                'message' => 'Successful import of skins',
            ], 200);
        } catch (\Throwable $th) {
            $httpMethod = Route::current()->methods()[0];
            $routeName = Route::currentRouteName();
            Log::error("Error executing request: [$httpMethod] \"$routeName\": " . $th->getMessage());

            return response()->json([
                'message' => 'Incorrect structure of the uploaded file, non-compliance with the rules regarding the uniqueness of the skin pattern for the current game item',
            ], 500);
        }
    }
}
