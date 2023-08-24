<?php

namespace App\Exports;

use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class SalesOrderExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterSoPending;
    private $status;
    public function __construct($status){
        $this->status = $status;
        if($this->status == 'P'){
            $this->masterSoPending = SoMaster::with('sodtl.stock','domst.dodtl','customer')->where('fc_sotype', 'Retail')->where('fc_sostatus', 'P')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else if($this->status == 'C'){
            $this->masterSoPending = SoMaster::with('sodtl.stock','domst.dodtl','customer')->where('fc_sotype', 'Retail')->where('fc_sostatus', 'C')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else if($this->status == 'DD'){
            $this->masterSoPending = SoMaster::with('sodtl.stock','domst.dodtl','customer')->where('fc_sotype', 'Retail')->where('fc_sostatus', 'DD')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else if($this->status == 'F'){
            $this->masterSoPending = SoMaster::with('sodtl.stock','domst.dodtl','customer')->where('fc_sotype', 'Retail')->where('fc_sostatus', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else{
            $this->masterSoPending = SoMaster::with('domst.dodtl','customer')->where('fc_sotype', 'Retail')->where('fc_branch', auth()->user()->fc_branch)->get();
        }
       
    }

    public function view(): ViewView{
        return view('apps.excel.master_so_pending',[
            'masterSoPending' => $this->masterSoPending
        ]);
    }
}
