<?php
// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'title',
        'description',
        'priority',
        'status',
        'completed_at',
        'assigned_to'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'Open',
        'priority' => 'Medium'
    ];

    // Relasi dengan User (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi dengan TicketResponse
    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    // Relasi dengan StatusLog
    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class);
    }

    // Relasi dengan User (penanggung jawab)
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Generate nomor tiket otomatis
    public static function generateTicketNumber()
    {
        $prefix = 'TKT';
        $date = date('Ymd');
        $lastTicket = self::whereDate('created_at', today())->latest()->first();
        
        if ($lastTicket) {
            $lastNumber = intval(substr($lastTicket->ticket_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . '-' . $date . '-' . $newNumber;
    }

    // Accessor untuk warna priority
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'High' => 'danger',
            'Medium' => 'warning',
            'Low' => 'success',
            default => 'secondary'
        };
    }

    // Accessor untuk warna status
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Open' => 'danger',
            'In Progress' => 'warning',
            'Resolved' => 'success',
            'Closed' => 'secondary',
            default => 'secondary'
        };
    }

    // Accessor untuk badge priority
    public function getPriorityBadgeAttribute()
    {
        $colors = [
            'High' => 'danger',
            'Medium' => 'warning',
            'Low' => 'success'
        ];
        
        $color = $colors[$this->priority] ?? 'secondary';
        return "<span class='badge bg-{$color}'>{$this->priority}</span>";
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'Open' => 'danger',
            'In Progress' => 'warning',
            'Resolved' => 'success',
            'Closed' => 'secondary'
        ];
        
        $color = $colors[$this->status] ?? 'secondary';
        return "<span class='badge bg-{$color}'>{$this->status}</span>";
    }
}