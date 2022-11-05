<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;

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
}
