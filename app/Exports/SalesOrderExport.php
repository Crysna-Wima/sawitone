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
    public function __construct(){
        $this->masterSoPending = SoMaster::with('domst','customer')->where('fc_sotype', 'Retail')->where('fc_sostatus', 'P')->where('fc_branch', auth()->user()->fc_branch)->get();
    }

    public function view(): ViewView{
        return view('apps.excel.master_so_pending',[
            'masterSoPending' => $this->masterSoPending
        ]);
    }
}
