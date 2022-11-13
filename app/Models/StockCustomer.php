<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use App\Traits\CompositeKey;

class StockCustomer extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_stockcustomer';
    protected $primaryKey = 'fc_membercode';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode', 'fc_barcode', 'fc_membercode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_stockcode', 'fc_stockcode')->withTrashed();
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'fc_membercode', 'fc_membercode')->withTrashed();
    }
}
