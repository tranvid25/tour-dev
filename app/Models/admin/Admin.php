<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class Admin extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $table = 'tbl_admin';
    protected $primaryKey = 'adminId';

    protected $fillable = [
        'userName',
        'passWord',
        'email',
        'createdDate',
    ];

    protected $hidden = [
        'passWord',
    ];

    // Override để Laravel biết dùng cột nào làm mật khẩu
    public function getAuthPassword()
    {
        return $this->passWord;
    }
    public $timestamps = false;
}
