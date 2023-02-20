<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class DoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_domst';
    protected $primaryKey = 'fc_dono';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function somst(){
        return $this->belongsTo(SoMaster::class, 'fc_sono', 'fc_sono');
    }

    public function dodtl(){
        return $this->hasMany(DoDetail::class, 'fc_dono', 'fc_dono');
    }

}
