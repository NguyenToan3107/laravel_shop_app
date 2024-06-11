<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'password', 'age', 'phoneNumber', 'address', 'role', 'image_path'];
    protected $hidden = ['password'];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
