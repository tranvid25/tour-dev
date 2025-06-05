<?php

namespace App\Models\clients;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table='tbl_comment';
    protected $primaryKey='commentId';
    protected $fillable=[
        'tourId',
        'userId',
        'comment',
        'avatar_user',
        'name_user',
        'level',
        'parent_id',
        'time'
    ];
    public $timestamps=false;
    protected $casts=[
        'time'=>'datetime',
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    //quan hệ với chính nó
    public function replies(){
        return $this->hasMany(Comment::class,'parent_id');
    }
    public function parent(){
        return $this->belongsTo(Comment::class,'parent_id');
    }
    //tự động set time khi tạo comment
    protected static function boot()
    {
        parent::boot();
        static::creating(function($comment){
            $comment->time=Carbon::now();
        });
    }
}
