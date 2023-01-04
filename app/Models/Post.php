<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'desc', 'content', 'votes'];

    public function Comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function Publisher() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
