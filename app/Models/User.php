<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\CompositeKey;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, logsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_user';
    protected $primaryKey = 'fc_userid';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_userid'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];
    protected $hidden = [
        'fc_password',
        'remember_token',
    ];

     public function scopeActive($query){
        $query->where('fl_level', 'T');
    }
}
