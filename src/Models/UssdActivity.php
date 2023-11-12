<?php

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; ## parent app user instance
use Illuminate\Support\Str;

class UssdActivity extends Model
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

    public function ussdActivityLogs()
    {
        return $this->hasMany(UssdActivityLog::class);
    }

    public function ussdMessages()
    {
        return $this->hasMany(UssdMessage::class, 'session_id', 'session_id');
    }

    public function ussdUser()
    {
        return $this->belongsTo(UssdUser::class, 'msisdn', 'msisdn');
    }

    public function session()
    {
        return $this->belongsTo(UssdSession::class, 'session_id', 'session_id');
    }
}