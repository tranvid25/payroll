<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table='comment';
    protected $primaryKey='maComment';
    protected $fillable=[
        'maComment',
        'username',
        'useremail',
        'comment',
        'maBaiViet',
        'maPhim',
    ];
    public function baiViet()
    {
        return $this->belongsTo(TinTuc::class,'maBaiViet','maBaiViet');
    }
    public function tinphim(){
        return $this->hasMany(Movie::class,'maPhim','maPhim');
    }
}
