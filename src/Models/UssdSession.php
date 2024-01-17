<?php

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class UssdSession extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(UssdActivity::class, 'session_id', 'session_id');
    }
}