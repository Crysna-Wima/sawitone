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
        return $this->hasone(SoMaster::class, 'fc_sono', 'fc_sono');
    }
    
    public function domst(){
        return $this->hasone(DoMaster::class, 'fc_dono', 'fc_dono');
    }

    public function pomst(){
        return $this->hasone(PoMaster::class, 'fc_pono', 'fc_pono');
    }

    public function romst(){
        return $this->hasone(RoMaster::class, 'fc_rono', 'fc_rono');
    }
}
