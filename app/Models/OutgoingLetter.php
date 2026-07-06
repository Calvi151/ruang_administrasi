<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'letter_number', 'date_sent', 'letter_type_id', 
        'creator_id', 'recipient', 'subject', 'content', 'status', 'file_path'
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
