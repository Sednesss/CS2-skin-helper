<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\GameItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GameItemController extends Controller
{
    public function index(): View
    {
        $gameItems = GameItem::withCount('skins')->paginate(7);
        return view('admin_panel.game_items.index', [
            'gameItems' => $gameItems,
        ]);
    }

    // public function create(ManagementCompany $managementCompany = null)
    // {
    //     $user = Auth::user();
    //     $user->role = $user->getRoleName();

    //     if ($user->role != User::ADMIN && $user->isAdminUK()) {
    //         $user->role = User::ADMIN_UK;
    //     }

    //     return view('admin_panel.users.create', [
    //         'user' => $user,
    //         'management_company' => $managementCompany
    //     ]);
    // }

    // public function store(StoreRequest $request): RedirectResponse
    // {
    //     $authUser = Auth::user();

    //     $user = User::create([
    //         'name' => $request->name,
    //         'surname' => $request->surname,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password)
    //     ]);

    //     if ($request->user_type == "customer") {
    //         $user->phone = $request->phone;
    //         $user->save();

    //         $address = Address::find($request->address);
    //         $customer = Customer::create([
    //             'user_id' => $user->id
    //         ]);
    //         $customer->addresses()->attach($address);
    //         $user->changeRole(User::CUSTOMER);
    //     } elseif ($request->user_type == "performer") {
    //         $user->phone = $request->phone;
    //         $user->save();

    //         $performer = $user->performer;
    //         if (!$performer) {
    //             $performer = Performer::create([
    //                 'user_id' => $user->id,
    //                 'management_company_id' => $request->management_company_id,
    //             ]);
    //         }
    //         $user->changeRole(User::PERFORMER);
    //     } elseif ($request->user_type == "administrator_mangement_company") {
    //         $ukAdminPermissionTitle = ManagementCompany::find($request->management_company_id)
    //             ->getPermissionTitleForAdminManagementCompany();

    //         $user->givePermissionTo($ukAdminPermissionTitle);
    //     } elseif ($request->user_type == "duty") {
    //         $user->changeRole(User::ADMIN);
    //     } elseif ($request->user_type == "administrator") {
    //         $user->changeRole(User::OWNER);
    //     }

    //     if ($authUser->getRoleName() == User::OWNER) {
    //         return redirect()->route('admin::users::index', $request->management_company_id);
    //     }
    //     return redirect()->route('admin::management_companies::show::admin', $request->management_company_id);
    // }

    // public function show(User $user): View
    // {
    //     return view('admin_panel.users.show', [
    //         'user' => $user,
    //         'canEdit' => $user->id == Auth::user()->id
    //     ]);
    // }

    // public function destroy(DeleteRequest $request): RedirectResponse
    // {
    //     $address = Address::find($request->address_id);

    //     if(count($address->childrens) == 0){
    //         $address->delete();
    //     }

    //     return redirect()->route('admin::addresses::index');
    // }
}
