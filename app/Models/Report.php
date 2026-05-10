<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'location',
        'latitude',
        'longitude',
        'status',
        'assigned_to',
        'responded_at',
        'resolved_at',
        'station_id',
        'verification_status',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'resolved_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // The citizen who reported
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The admin/responder assigned to this report
    public function responder()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Timeline of updates
    public function updates()
    {
        return $this->hasMany(ReportUpdate::class);
    }

    // Attachments (photos/videos)
    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    // Messages (chat) associated with this report
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Notifications related to this report
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function getVerificationBadgeAttribute()
    {
        return match($this->verification_status) {
            'legit' => '<span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs font-semibold">✓ Legit</span>',
            'scam'  => '<span class="bg-red-100 text-red-800 px-2 py-0.5 rounded-full text-xs font-semibold">⚠️ Scam</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-semibold">❓ Unverified</span>',
        };
    }
    
}