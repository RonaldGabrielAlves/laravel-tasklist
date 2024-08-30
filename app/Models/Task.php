<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'task',
        'status',
        'deadline',
        'edited_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'deadline' => 'date',
        'edited_at' => 'date',
    ];

    public $timestamps = false;

    public function getDeadlineAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getEditedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
