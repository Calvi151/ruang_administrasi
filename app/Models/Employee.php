<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = 'employee';
    protected $fillable = ['nip', 'name', 'email', 'photo', 'number'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
