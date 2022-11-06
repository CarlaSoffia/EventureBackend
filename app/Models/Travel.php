<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $table = 'travels';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;

        /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','days','city_id','accomodation_id','avg_distance'
    ];

    public function eateries(){
        return $this->belongsToMany(Eatery::class, 'travels_eateries');
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function accomodation(){
        return $this->belongsTo(Accomodation::class);
    }
    public function routes(){
        return $this->hasMany(Route::class);
    }
}
