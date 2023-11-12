<?php

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UssdUser extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($col){
            $col->uuid = Str::orderedUuid()->toString();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $guarded = ['id'];

    public function ussdActivities()
    {
        return $this->hasMany(UssdActivity::class, 'msisdn', 'msisdn');
    }

    public function ussdMessages()
    {
        return $this->hasMany(UssdMessage::class, 'msisdn', 'msisdn');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'msisdn', 'msisdn');
    }

    public function session()
    {
        return $this->belongsTo(UssdSession::class, 'session_id', 'session_id');
    }
}