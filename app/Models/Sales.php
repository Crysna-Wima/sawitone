<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class Sales extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_sales';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_salescode'];
    protected $guarded = [];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }

    public function sales_type(){
        return $this->belongsTo(TransaksiType::class, 'fc_salestype', 'fc_kode');
    }

    public function sales_level(){
        return $this->belongsTo(TransaksiType::class, 'fn_saleslevel', 'fc_kode');
    }

    public function sales_bank1(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank1', 'fc_bankcode');
    }

    public function sales_bank2(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank2', 'fc_bankcode');
    }

    public function sales_bank3(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank3', 'fc_bankcode');
    }
}
