<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Party;
use App\Models\Restaurant;
use Auth;

class PartyController extends Controller
{
    //
    public function index() {
        // $parties = Party::with(['user'])->get();

        $parties = DB::table('parties')
            ->join('users', 'parties.user_id', '=', 'users.id')
            ->get([
                'parties.id AS id',
                'parties.description',
                'users.name AS name',
            ]);        

        return view('party.index', [
            'parties' => $parties,
        ]);
    }

    public function show($id) {
        $party = Party::find($id);
        $user = DB::table('users')->where('id', '=', $party->user_id)->first();
        $restaurants = $party->restaurants;

        return view('party.show', [
            'party' => $party,
            'user' => $user,
            'restaurants' => $restaurants,
        ]);
    }    

    public function create()
    {
        return view('party.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'description' => 'required|max:30',
            'restaurant-1' => 'required|max:20',
            'restaurant-2' => 'required|max:20',
            'restaurant-3' => 'required|max:20',
        ]);
        
        $user = Auth::user();
        $party = new Party();
        $party->description = $request->input('description');
        $party->user_id = $user->id;
        $party->save();
        
        $restaurant_1 = Restaurant::firstOrNew([
            'name' => $request->input('restaurant-1')
        ]);
        $restaurant_1->save();
        $party->restaurants()->attach($restaurant_1->id);
        
        $restaurant_2 = Restaurant::firstOrNew([
            'name' => $request->input('restaurant-2')
        ]);
        $restaurant_2->save();
        $party->restaurants()->attach($restaurant_2->id);
        
        $restaurant_3 = Restaurant::firstOrNew([
            'name' => $request->input('restaurant-3')
        ]);
        $restaurant_3->save();
        $party->restaurants()->attach($restaurant_3->id);
        
        return redirect()
            ->route('party.index')
            ->with('success', "Successfully created {$party->description}!");        
    }

    public function unfavorite($id) {
        $user = Auth::user();
        $user->parties()->detach($id);

        return redirect()->route('profile.index');
    }

    public function favorite($id) {
        $user = Auth::user();
        $user->parties()->syncWithoutDetaching($id);
        return redirect()->route('party.show', [ 'id' => $id ])->with('success', "You have favorited this party!");
    }    
}
