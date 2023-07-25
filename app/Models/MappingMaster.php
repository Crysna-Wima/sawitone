<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MappingMaster extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_mappingmst';
    protected $primaryKey = 'fc_mappingcode';
    public $incrementing = false;
    protected $guarded = ['type'];

 
}
