<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempSoMaster extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempsomst';
    protected $primaryKey = 'fc_sono';
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function member_tax_code(){
        return $this->belongsTo(Stock::class, 'fc_membertaxcode', 'fc_kode')->withTrashed();
    }

    public function sales(){
        return $this->belongsTo(Supplier::class, 'fc_salescode', 'fc_salescode')->withTrashed();
    }
}
