<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TempInvoiceDtl extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_tempinvdtl';
    protected $primaryKey = 'fn_invrownum';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function tempinvmst(){
        return $this->hasOne(TempInvoiceMst::class, 'fc_invno', 'fc_invno');
    }
}
