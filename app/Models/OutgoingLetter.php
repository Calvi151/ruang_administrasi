<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'letter_number', 'category', 'incoming_letter_id', 'date_sent', 'letter_type_id', 
        'creator_id', 'recipient', 'subject', 'content', 'status', 'file_path',
        'delivery_method', 'delivery_note', 'delivered_at', 'approved_at'
    ];

    protected $casts = [
        'date_sent'    => 'date',
        'delivered_at' => 'datetime',
        'approved_at'  => 'datetime',
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function incomingLetter()
    {
        return $this->belongsTo(IncomingLetter::class, 'incoming_letter_id');
    }

    public function isReply(): bool
    {
        return $this->category === 'balasan' || !is_null($this->incoming_letter_id);
    }

    public function isApproved(): bool
    {
        return in_array($this->status, ['acc', 'delivered']);
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }
}
