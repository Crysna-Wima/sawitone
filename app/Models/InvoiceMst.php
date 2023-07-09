<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceMst extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_invmst';
    protected $primaryKey = 'fn_invno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function invdtl(){
        return $this->hasMany(InvoiceDtl::class, 'fc_invno','fc_invno');
    }

    public function somst(){
        return $this->hasone(SoMaster::class, 'fc_suppdocno', 'fc_sono');
    }
    
    public function domst(){
        return $this->hasone(DoMaster::class, 'fc_child_suppdocno', 'fc_dono');
    }

    public function pomst(){
        return $this->hasone(PoMaster::class, 'fc_suppdocno', 'fc_pono');
    }

    public function romst(){
        return $this->hasone(RoMaster::class, 'fc_child_suppdocno', 'fc_rono');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'fc_membercode', 'fc_entitycode');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'fc_suppliercode', 'fc_entitycode');
    }
}
