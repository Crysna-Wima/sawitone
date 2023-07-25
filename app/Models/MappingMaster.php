<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MappingMaster extends Model
{
    use HasFactory, LogsActivity, Blameable, CompositeKey, SoftDeletes;

    protected static $logAttributes = ["*"];
    protected $table = 't_mappingmst';
    protected $primaryKey = 'fc_mappingcode';
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
       return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_branch')->where('fc_trx', 'BRANCH')->withTrashed();
    }
}
