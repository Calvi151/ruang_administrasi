<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    use HasFactory;
    protected $fillable = ['letter_number', 'date_received', 'sender', 'subject', 'file', 'file_path'];
}
