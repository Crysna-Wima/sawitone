<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class Supplier extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_supplier';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_suppliercode'];
    protected $guarded = [];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }

    public function supplier_legal_status(){
        return $this->belongsTo(TransaksiType::class, 'fc_supplierlegalstatus', 'fc_kode');
    }

    public function supplier_nationality(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliernationality', 'fc_kode');
    }

    public function supplier_type_business(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliertypebusiness', 'fc_kode');
    }

    public function supplier_tax_code(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliertaxcode', 'fc_kode');
    }

    public function supplier_bank1(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank1', 'fc_bankcode');
    }

    public function supplier_bank2(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank2', 'fc_bankcode');
    }

    public function supplier_bank3(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank3', 'fc_bankcode');
    }

}
