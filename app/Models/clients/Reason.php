<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    protected $table='tbl_reason';
    protected $primaryKey='reasonId';
    protected $fillable=[
        'reasonName'
    ];
    public $timestamps=false;
}
