<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\OrganizationConfig;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $model = Invoice::with('client','items')->withCount('items')->when(!isset($request->filter['total']) || $request->filter['total'] == null, function($query) use ($request)
        {
            return $query->orderBy('created_at','desc');
        })
        ->when(isset($request->filter['client']) && $request->filter['client'] !== null, function($query) use ($request){
            return $query->where('client_id',$request->filter['client']);
        })
        ->when(isset($request->filter['due_date']) && $request->filter['due_date'] !== null, function($query) use ($request){
            $date = explode('-',$request->filter['due_date']);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
            return $query->whereBetween('due_date',[$start,$end]);
        })
        ->when(isset($request->filter['status']) && $request->filter['status'] !== null, function($query) use ($request){
            return $query->where('status',$request->filter['status']);
        })
        ->when(isset($request->filter['total']) && $request->filter['total'] !== null, function($query) use ($request){
            return $query->orderBy('total',$request->filter['total']);
        })
            ->paginate(10);
        // $model = Invoice::with('client','items')->paginate(10);
        $client = Client::get();
        return view('invoice.index')->with('model',$model)->with('item')->with('client',$client);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model = new Invoice();
        $client = Client::get();
        $item = 1;
        return view('invoice.form')->with('model',$model)
        ->with('client',$client)->with('item',$item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //
        $security_code = sprintf("%06d", mt_rand(1, 999999));
        $data = $request->validated();
        $data['security_code'] = $security_code;
        try{
            
        $items = [];
            $invoice = new Invoice();
            $invoice->no_inv = $data['no_inv'];
            $invoice->security_code = $data['security_code'];
            $invoice->client_id = $data['client_id'];
            $invoice->total = $data['total'];
            $invoice->due_date = Carbon::parse($data['due_date']);
            $invoice->status = $data['status'];
            $invoice->notes = $data['notes'];
            $invoice->paid_at = $data['paid_at'] ? $data['paid_at'] : null;
            $invoice->save();

            if($invoice->status == "PAID"){
                $dataPayment = [
                    'references_code'=>'MANUAL',
                    'id_invoice'=>$invoice->id,
                    'method'=>"MANUAL",
                    'total_amount'=>$invoice->total,
                    'fee_merchant'=>0,
                    'fee_customer'=>0,
                    'total_fee'=>0,
                    'amount_received'=>$invoice->total,
                    'status'=>'SUCCESS'
                ];
                Payment::create($dataPayment);
            }

            for($i=0;$i<count($request->item_name);$i++){
                $calculation = $data['item_qty'][$i] * $data['item_price'][$i];
                $adjustment = $calculation*($data['item_adjustment'][$i]/100);
                $itemTotal = $calculation - $adjustment;
                $items [] = [
                    'invoice_id'=>$invoice->id,
                    'item_name'=>$data['item_name'][$i],
                    'qty_type' => $data['item_qty_type'][$i],
                    'qty'=>$data['item_qty'][$i],
                    'price'=>$data['item_price'][$i],
                    'adjustment'=>$adjustment,
                    'total'=>$itemTotal,
                    'item_note'=>$data['item_note'][$i]
                ];
            }
            $invoice->items()->createMany($items);
            return back()->with('success','Success Invoice has been saved');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())->with('model',$request->validated());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = Invoice::with('items','client')->withCount('items')->findOrFail($id);
        return view('invoice.form')->with('model',$model)
        ->with('item',$model->items_count);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Invoice $invoice)
    {
        //
        try{
            $security_code = sprintf("%06d", mt_rand(1, 999999));
            $data = $request->validated();
            $data['security_code'] = $security_code;
            $items = [];

            if($invoice->status == "PAID"){
            $invoice->paid_at = $data['paid_at'];
                $dataPayment = [
                    'references_code'=>'MANUAL',
                    'id_invoice'=>$invoice->id,
                    'method'=>"MANUAL",
                    'total_amount'=>$invoice->total,
                    'fee_merchant'=>0,
                    'fee_customer'=>0,
                    'total_fee'=>0,
                    'amount_received'=>$invoice->total,
                    'status'=>'SUCCESS'
                ];
                Payment::create($dataPayment);
            }
            
            $oldData = InvoiceDetail::where('invoice_id',$invoice->id);
            $oldData->delete();

            for($i=0;$i<count($request->item_name);$i++){
                $calculation = $data['item_qty'][$i] * $data['item_price'][$i];
                $adjustment = $calculation*($data['item_adjustment'][$i]/100);
                $itemTotal = $calculation - $adjustment;
                $items = [
                    'invoice_id'=>$invoice->id,
                    'item_name'=>$data['item_name'][$i],
                    'qty_type' => $data['item_qty_type'][$i],
                    'qty'=>$data['item_qty'][$i],
                    'price'=>$data['item_price'][$i],
                    'adjustment'=>$adjustment,
                    'total'=>$itemTotal,
                    'item_note'=>$data['item_note'][$i]
                ];
                InvoiceDetail::create($items);
            }
            $invoice->update($data);
            return back()->with('success','Success Invoice has been updated');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())->with('model',$invoice);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    public function generate($client_id){
        $client = Client::withCount('invoices')->findOrFail($client_id);
        $invoiceCount = sprintf("%04u", ($client->invoices_count+1));
        $invoiceNo = $client->code ."-".$invoiceCount;
        return $invoiceNo;
    }
    
    public function download($id){
        //get invoice & client data
        $model = DB::table('invoices')->join('clients','clients.id','=','invoices.client_id')
        ->select("*")->where('invoices.id',$id)->first();
        //get item invoices
        $item = DB::table('invoice_details')->where('invoice_id',$id)->get();
        //get organization profile
        $profile =  DB::table('organization_configs')
        ->select('*')
        ->first();
        $bank = DB::table('banks')->where('status','active')->get();
        $dompdf = new Dompdf();
        $pdf = PDF::loadView('invoice.download',['model'=>$model,'items'=>$item,'profile'=>$profile,'banks'=>$bank])->setPaper('a4','potrait')->setWarnings(false);
        return $pdf->stream();
        
        
        
        // $dompdf->loadHTML($pdf,'UTF-8');
        // $dompdf->setPaper('A4','landscape');
        // $dompdf->render();
        // return $dompdf->stream();
        //return $pdf->stream('Invoice-'.$model->code.'_'.Carbon::parse($model->created_at)->format('d_m_Y'));
    }
}
