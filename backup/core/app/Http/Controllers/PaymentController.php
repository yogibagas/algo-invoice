<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoicePayment($no){
        
        $invoice = Invoice::with('items','client')->where('no_inv', $no)->first();

        $endpoint = "https://payment.tripay.co.id/api-sandbox/payment/channel";
        $client = new \GuzzleHttp\Client();

        $response = Http::withToken(env('TRIPAY_APIKEY'))
        ->get("https://payment.tripay.co.id/api-sandbox/merchant/payment-channel");
        
        return view('invoice.payment.index')->with('model',$invoice)->with('channel',$response->json());
    }
    public function handler($no, PaymentRequest $request){

        $invoice = Invoice::with('client','items')->where('no_inv',$no)->first();

        $apiKey = env('TRIPAY_APIKEY');
        $privateKey = env('TRIPAY_PRIVATEKEY');
        $merchantCode = env('TRIPAY_MERCHANTCODE');
        $merchantRef = $no;
        $method = $request->selected_item;
        $itemCart = [];
        foreach($invoice->items as $item){
            $itemCart [] = array(
                'sku' => $item->item_name,
                'name' => $item->note ? $item->note : $item->item_name,
                'price' => $item->adjustment ? $item->price - ($item->adjustment/$item->qty) : $item->price,
                'quantity' => $item->qty
            );
            // echo $item->item_name;
        }
        $amount = $invoice->total;
        $expDate = Carbon::createFromFormat('Y-m-d H:i:s',$invoice->due_date);
        $dateNow = Carbon::now();
        $now = Carbon::createFromFormat('Y-m-d H:i:s',$dateNow);
        $expired = $now->diffInSeconds($expDate);
        $data = [
            'method'            => $method,
            'merchant_ref'      => $merchantRef,
            'amount'            => $invoice->total,
            'customer_name'     => $invoice->client->name,
            'customer_email'    => $invoice->client->email,
            'customer_phone'    => $invoice->client->phone,
            'order_items'       => $itemCart,
            'callback_url'      => route('payment.callback'),
            'return_url'        => 'http://algoapp.test/payment/'.$no,
            'expired_time'      => (time()+($expired)),
            'signature'         => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
            ];


            $endpoint = "https://payment.tripay.co.id/api-sandbox/transaction/create";
            $client = new \GuzzleHttp\Client();
            // dd($data);

            $response = Http::withToken(env('TRIPAY_APIKEY'))
            ->post($endpoint, $data);
            dd($response->json());
            
            $payment = new Payment();
            $payment->
            dd($response->json());

        
        return true;
    }

    public function callbackHandler(Request $request){
        // ambil callback signature
		$callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE') ?? '';

		// ambil data JSON
		$json = $request->getContent();

		// generate signature untuk dicocokkan dengan X-Callback-Signature
		$signature = hash_hmac('sha256', $json, env('TRIPAY_PRIVATEKEY'));

		// validasi signature
		if( $callbackSignature !== $signature ) {
		    return "Invalid Signature"; // signature tidak valid, hentikan proses
		}

		$data = json_decode($json);
		$event = $request->server('HTTP_X_CALLBACK_EVENT');

		if( $event == 'payment_status' )
		{
		    if( $data->status == 'PAID' )
		    {
		        $merchantRef = $data->merchant_ref;

		        // pembayaran sukses, lanjutkan proses sesuai sistem Anda, contoh:
		        $order = Order::where('id', $merchantRef)->first();

		        if( !$order ) {
		        	return "Order not found";
		    	}

		    	$order->update([
		    		'status'	=> 'PAID'
		    	]);

		    	return response()->json([
		    		'success' => true
		    		]);
		    }
		}

		return "No action was taken";
    }
}
