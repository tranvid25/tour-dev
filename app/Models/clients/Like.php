<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='likes';
    protected $primaryKey='likeId';
    protected $fillable=[
      'tourId',
      'userId'
    ];
    public $timestamps=false;
    public function tour(){
       return $this->belongsTo(Tour::class,'tourId');
    }
    public function user(){
       return $this->belongsTo(User::class,'userId');
    }
}
