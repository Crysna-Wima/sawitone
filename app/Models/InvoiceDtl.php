<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceDtl extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_invdtl';
    protected $primaryKey = 'fn_invrownum';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function invmst(){
        return $this->hasOne(InvoiceMst::class, 'fc_invno', 'fc_invno');
    }
}
