<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class Customer extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected static function boot()
    {
        parent::boot();

        if(auth()->check()){
            static::addGlobalScope('branch', function (Builder $builder) {
                $builder->where('fc_branch', '=', auth()->user()->fc_branch);
            });
        }
    }

    protected $table = 't_customer';
    protected $primaryKey = 'fc_membercode';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_membercode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function member_type_business(){
        return $this->belongsTo(TransaksiType::class, 'fc_membertypebusiness', 'fc_kode')->withTrashed();
    }

    public function member_typebranch(){
        return $this->belongsTo(TransaksiType::class, 'fc_member_branchtype', 'fc_kode')->withTrashed();
    }

    public function member_legal_status(){
        return $this->belongsTo(TransaksiType::class, 'fc_memberlegalstatus', 'fc_kode')->withTrashed();
    }

    public function member_tax_code(){
        return $this->belongsTo(TransaksiType::class, 'fc_membertaxcode', 'fc_kode')->withTrashed();
    }

    public function member_nationality(){
        return $this->belongsTo(TransaksiType::class, 'fc_membernationality', 'fc_kode')->withTrashed();
    }

    public function member_bank1(){
        return $this->belongsTo(BankAcc::class, 'fc_memberbank1', 'fc_bankcode')->withTrashed();
    }

    public function member_bank2(){
        return $this->belongsTo(BankAcc::class, 'fc_memberbank2', 'fc_bankcode')->withTrashed();
    }

    public function member_bank3(){
        return $this->belongsTo(BankAcc::class, 'fc_memberbank3', 'fc_bankcode')->withTrashed();
    }
}
