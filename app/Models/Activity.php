<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'activities';

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
       'designation','category_id','location_id','avg_price','avg_ratings','avg_time_sec'
   ];

   public function location(){
       return $this->hasOne(Location::class);
   }
}
