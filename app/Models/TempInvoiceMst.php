<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TempInvoiceMst extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttribute = ["*"];
    protected $table = 't_tempinvmst';
    protected $primaryKey = 'fc_invno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function tempinvdtl(){
        return $this->hasMany(TempInvoiceDtl::class, 'fc_invno','fc_invno');
    }

    public function somst(){
        return $this->hasOne(SoMaster::class, 'fc_suppdocno', 'fc_sono');
    }
    
    public function domst(){
        return $this->hasOne(DoMaster::class, 'fc_dono','fc_child_suppdocno');
    }

    public function pomst(){
        return $this->hasOne(PoMaster::class,'fc_pono', 'fc_suppdocno');
    }

    public function romst(){
        return $this->hasOne(RoMaster::class, 'fc_child_suppdocno', 'fc_rono');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'fc_membercode','fc_entitycode');
    }

    public function supplier(){
        return $this->hasOne(Supplier::class, 'fc_suppliercode', 'fc_entitycode');
    }
}
