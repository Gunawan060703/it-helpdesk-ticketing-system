<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'old_status',
        'new_status',
        'changed_by'
    ];

    // Relasi dengan Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relasi dengan User yang melakukan perubahan
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}