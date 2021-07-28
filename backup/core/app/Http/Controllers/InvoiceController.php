<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model = Invoice::with('client','items')->withCount('items')->paginate(15);
        return view('invoice.index')->with('model',$model)->with('item');
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
        // dd($request->toArray());
        try{
            $invoice = new Invoice();
            $invoice->no_inv = $data['no_inv'];
            $invoice->security_code = $data['security_code'];
            $invoice->client_id = $data['client_id'];
            $invoice->total = $data['total'];
            $invoice->due_date = Carbon::parse($data['due_date']);
            $invoice->status = $data['status'];
            $invoice->save();

            for($i=0;$i<count($request->item_name);$i++){
                $calculation = $data['item_qty'][$i] * $data['item_price'][$i];
                $adjustment = $calculation*($data['item_adjustment'][$i]/100);
                $itemTotal = $calculation - $adjustment;

                $item = new InvoiceDetail();
                $item->invoice_id = $invoice->id;
                $item->item_name = $data['item_name'][$i];
                $item->qty_type = $data['item_qty_type'][$i];
                $item->qty = $data['item_qty'][$i];
                $item->price = $data['item_price'][$i];
                $item->adjustment = $adjustment;
                $item->item_note=$data['item_note'][$i];
                $item->total = $itemTotal;
                $item->save();
            }
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
            $invoice->update($data);
            
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
            return back()->with('success','Success Invoice has been updated');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())->with('model',$invoice);
        }

        // foreach($items as $item){
        //     // $invoice->items()->update($item);
        // }
        // $invoice->items()->update()
        
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
}
