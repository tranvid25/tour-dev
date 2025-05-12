<?php

namespace App\Models\clients;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $table='tbl_users';
    protected $primaryKey = 'userId';
    protected $fillable=[
        'userName',
        'passWord',
        'phoneNumber',
        'email',
        'google_id',
        'facebook_id',
        'address',
        'ipAdress',
        'status',
        'level',
        'avatar'
    ];
    public $timestamps = false;
    protected $dispatchesEvents=[
       'created'=>UserCreated::class,
       'updated'=>UserUpdated::class,
       'deleted'=>UserDeleted::class
    ];
}
