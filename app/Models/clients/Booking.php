<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='tbl_booking';
    protected $primaryKey='bookingId';
    protected $fillable=[
      'tourId',
      'userId',
      'bookingDate',
      'numAdults',
      'numChildren',
      'totalPrice',
      'bookingStatus',
      'specicalRequestes',
      'reasonId',
      'note'
    ];
    protected $dates=['deleted_at'];
    public function tour(){
        return $this->belongsTo(Tour::class,'tourId');
    }
    public function user(){
        return $this->belongsTo(User::class,'userId');
    }
    public $timestamps=false;
}
