<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    use HasFactory;

    protected $fillable = ['letter_number', 'date_received', 'sender', 'subject', 'file', 'file_path'];

    protected $casts = [
        'date_received' => 'date',
    ];

    public function replies()
    {
        return $this->hasMany(OutgoingLetter::class, 'incoming_letter_id')->orderByDesc('created_at');
    }
}
