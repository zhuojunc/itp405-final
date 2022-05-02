<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Party;
use App\Models\Restaurant;
use App\Models\PartyRestaurant;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    //
    public function index($partyId, $restaurantId) {
        $partyRestaurant = DB::table('party_restaurant')->where([
            ['party_id', '=', $partyId],
            ['restaurant_id', '=', $restaurantId],
        ])->first();
        $party = Party::find($partyId);
        $restaurant = Restaurant::find($restaurantId);
        $users = DB::table('party_restaurant_user')
                    ->where('party_restaurant_id', '=', $partyRestaurant->id)
                    ->join('users', 'users.id', '=', 'party_restaurant_user.user_id')
                    ->orderByDESC('party_restaurant_user.created_at')
                    ->get([
                        'party_restaurant_user.user_id AS user_id',
                        'party_restaurant_user.id AS id',
                        'party_restaurant_user.comment AS comment',
                        'party_restaurant_user.updated_at AS updated_at',
                        'users.name AS name',
                    ]);

        return view('comment.index', [
            'partyRestaurant' => $partyRestaurant,
            'party' => $party,
            'restaurant' => $restaurant,
            'users' => $users,
        ]);
    }

    public function edit($id) {
        $party_restaurant_user = DB::table('party_restaurant_user')
            ->where('id', '=', $id)
            ->first();
        if (Gate::denies('edit-comment', $party_restaurant_user->user_id)) {
            abort(403);
        }            
        $party_restaurant = DB::table('party_restaurant')
            ->where('id', '=', $party_restaurant_user->party_restaurant_id) 
            ->first();
        $party = DB::table('parties')
            ->where('id', '=', $party_restaurant->party_id)
            ->first();
        $restaurant = DB::table('restaurants')
            ->where('id', '=', $party_restaurant->restaurant_id)
            ->first();
        return view('comment.edit', [
            'partyRestaurantUser' => $party_restaurant_user,
            'partyRestaurant' => $party_restaurant,
            'party' => $party,
            'restaurant' => $restaurant,
        ]);                                    
    }

    public function update($id, Request $request) {
        $partyRestaurantUser = DB::table('party_restaurant_user')
            ->where('id', '=', $id)
            ->first();
        if (Gate::denies('edit-comment', $partyRestaurantUser->user_id)) {
            abort(403);
        }        

        $request->validate([
            'comment' => 'required|max:30',
        ]);
        $timestamp = date('Y-m-d H:i:s');
        DB::table('party_restaurant_user')->where('id', $id)->update([
           'comment' => $request->input('comment'),
           'updated_at' => $timestamp,
        ]);
        $partyRestaurant = DB::table('party_restaurant')->where('id', '=', $request->input('partyRestaurant'))->first();
        return redirect()
        ->route('comment.index', [ 'partyId' => $partyRestaurant->party_id, 'restaurantId' => $partyRestaurant->restaurant_id ])
        ->with('success', "You just edited a comment here!");                
    }

    public function store(Request $request) {
        $request->validate([
            'comment' => 'required|max:30',
        ]);
        $user = Auth::user();
        $timestamp = date('Y-m-d H:i:s');
        DB::table('party_restaurant_user')->insert([
            'comment' => $request->input('comment'),
            'user_id' => $user->id,
            'party_restaurant_id' => $request->input('partyRestaurant'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        $partyRestaurant = DB::table('party_restaurant')->where('id', '=', $request->input('partyRestaurant'))->first();
        // $partyRestaurant = PartyRestaurant::find($request->input('partyRestaurant'));
        // $partyRestaurant->users()->attach($user->id, ['comment' => $request->input('comment')]);
        // $user->partyRestaurants()->attach($request->input('partyRestaurant'), ['comment' => $request->input('comment')]);

        return redirect()
        ->route('comment.index', [ 'partyId' => $partyRestaurant->party_id, 'restaurantId' => $partyRestaurant->restaurant_id ])
        ->with('success', "You just posted a comment here!");         
    }

    public function delete($id, Request $request) {
        DB::table('party_restaurant_user')->where('id', '=', $id)->delete();
        $partyRestaurant = DB::table('party_restaurant')->where('id', '=', $request->input('partyRestaurant'))->first();
        return redirect()
        ->route('comment.index', [ 'partyId' => $partyRestaurant->party_id, 'restaurantId' => $partyRestaurant->restaurant_id ])
        ->with('success', "You just deleted a comment here!"); 
    }
}
