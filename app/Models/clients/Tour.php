<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $table='tbl_tour';
    protected $primaryKey='tourId';
    protected $fillable=[
        'availability',
        'description',
        'destination',
        'duration',
        'images',
        'itinerary',
        'priceChild',
        'priceAdult',
        'quantity',
        'reviews',
        'title'
    ];
    public $timestamps = false;
    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
