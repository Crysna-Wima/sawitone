<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TrxAccountingMaster extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 't_temp_trxaccountingmst';
    protected $primaryKey = 'fc_trxno';
    public $incrementing = false;
    protected $guarded = ['type'];

    
}
