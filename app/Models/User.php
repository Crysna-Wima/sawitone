<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CompositeKey;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, logsActivity, CompositeKey, SoftDeletes;

    protected static $logAttributes = ["*"];

    protected $table = 't_user';
    protected $primaryKey = 'fc_userid';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_userid'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = ['branch_desc'];
    protected $hidden = [
        'fc_password',
    ];

    public function scopeActive($query){
        $query->where('fl_level', 'T');
    }

    public function getBranchDescAttribute(){
        return $this->branch->fv_description;
    }

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function group_user(){
        return $this->belongsTo(TransaksiType::class, 'fc_groupuser', 'fc_kode')->withTrashed();
    }
}
