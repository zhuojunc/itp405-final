<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];    

    public function parties() {
        return $this->belongsToMany(Party::class, 'party_restaurant')->using(PartyRestaurant::class)->withTimestamps();
    }     
}
