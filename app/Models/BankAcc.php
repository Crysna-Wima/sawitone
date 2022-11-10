<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use App\Traits\CompositeKey;

class BankAcc extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_bankacc';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_bankcode'];
    public $incrementing = false;
    protected $guarded = [];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }
}
