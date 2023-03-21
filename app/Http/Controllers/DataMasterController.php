<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Helpers\NoDocument;

use Carbon\Carbon;

use App\Helpers\ApiFormatter;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\StockCustomer;
use App\Models\Supplier;
use App\Models\TempSoMaster;
use App\Models\TransaksiType;
use Yajra\DataTables\DataTables;

class DataMasterCOntroller extends Controller
{
    public function get_data_all($model)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::all();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_by_id($model, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return ApiFormatter::getResponse($data);
    }

    public function get_data_where_field_id_first($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->first();
        return ApiFormatter::getResponse($data);
        // dd($data);
    }

    public function get_data_where_field_id_get($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return ApiFormatter::getResponse($data);
    }
    #================ DATA =====================#
    public function data_brand()
    {
        $data = Brand::select('fc_brand')->groupBy('fc_brand')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_group_by_brand(request $request)
    {
        $data = Brand::select('fc_group')->where('fc_brand', $request->fc_brand)->groupBy('fc_group')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_subgroup_by_group(request $request)
    {
        $data = Brand::select('fc_subgroup')->where('fc_group', $request->fc_group)->groupBy('fc_subgroup')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_stock_by_primary($stockcode, $barcode)
    {
        $data = Stock::where(['fc_stockcode' => $stockcode, 'fc_barcode' => $barcode])->first();
        return ApiFormatter::getResponse($data);
    }

    public function data_customer_first($fc_membercode)
    {
        $data = Customer::with('member_tax_code', 'member_typebranch', 'member_type_business', 'member_legal_status')->where('fc_membercode', $fc_membercode)->first();
        return ApiFormatter::getResponse($data);
    }

    public function generate_no_document(request $request)
    {
        $data = NoDocument::generate(Carbon::now()->format('Y'), $request->fv_document, $request->fc_branch, $request->fv_part);
        return ApiFormatter::getResponse($data);
    }


    #================ DATATABLES ===============#

    public function get_data_all_table($model)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::all();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_by_id_table($model, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_where_field_id_get_table($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function get_data_customer_so_datatables($fc_branch)
    {
        $data = Customer::with('member_type_business', 'member_typebranch', 'member_legal_status')->where('fc_branch', $fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_stock_so_datatables()
    {
        $data = Stock::with('namepack')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_stock_customer_so_datatables(){
        $fc_membercode = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first()->fc_membercode;
    $data = StockCustomer::with(['stock.namepack'])->where('fc_membercode', $fc_membercode)->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);   
    }
    

    public function get_data_stock_po_datatables()
    {
        $data = Stock::with('namepack')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function data_supplier_first($fc_suppliercode){
        $data = Supplier::with('supplier_tax_code', 'supplier_typebranch', 'supplier_type_business', 'supplier_legal_status')->where('fc_suppliercode', $fc_suppliercode)->first();
        return ApiFormatter::getResponse($data);
    }
}
