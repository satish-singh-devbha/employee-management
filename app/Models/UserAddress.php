<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id", 
        "street_name", 
        "building_no", 
        "city", 
        "state", 
        "country", 
        "pincode"
    ];

    public function cityFunc()
    {
        return $this->hasOne(City::class, "id", "city");
    }

    public function stateFunc()
    {
        return $this->hasOne(State::class, "id", "state");
    }

    public function countryFunc()
    {
        return $this->hasOne(Country::class, "id", "country");
    }
}
