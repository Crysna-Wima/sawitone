<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, logsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_user';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_userid'];
    protected $guarded = [];
    protected $appends = [];
    protected $hidden = [
        'fc_password',
        'remember_token',
    ];

    public function scopeActive($query){
        $query->where('status', 1);
    }
}
