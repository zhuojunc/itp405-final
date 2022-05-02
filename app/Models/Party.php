<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\PartyRestaurant;

class Party extends Model
{
    use HasFactory;
    public function restaurants() {
        return $this->belongsToMany(Restaurant::class, 'party_restaurant')->using(PartyRestaurant::class)->withTimestamps();
    } 
    
    public function users() {
        return $this->belongsToMany(User::class, 'party_user')->withTimestamps();
    }

    // public function user() {
    //     return $this->belongsTo(User::class, 'users');
    // }
}
