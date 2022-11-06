<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eatery extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'eateries';

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
       'designation','location_id','avg_price','avg_ratings'
   ];

   public function location(){
       return $this->hasOne(Location::class);
   }
   public function travels(){
    return $this->belongsToMany(Travel::class, 'travels_eateries');
}
}
