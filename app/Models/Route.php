<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
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
        'travel_id','progress','avg_time_minutes'
    ];

    public function travel(){
        return $this->belongsTo(Travel::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'routes_categories');
    }
}
