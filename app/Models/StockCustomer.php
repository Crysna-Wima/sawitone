<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class StockCustomer extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_stockcustomer';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode', 'fc_barcode', 'fc_membercode'];
    protected $guarded = [];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }

    public function member_code(){
        return $this->belongsTo(Customer::class, 'fc_membercode', 'fc_membercode');
    }
}
