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

    public function __construct(){
        if(env('APP_ENV') == "local"){
            $this->clientID = "MCH-0008-8668568659041";
            $this->secretKey = "SK-YDLXYSR38jQDsLmLnZHL";
            $this->urlPoint = "https://api-sandbox.doku.com";
        }else{
            $this->clientID = "MCH-0308-3278932443982";
            $this->secretKey = "SK-5soLXI3SRnTvs0U4CiMm";
            $this->urlPoint = "https://api.doku.com";
        }
    }

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

        
        return view('invoice.payment.index')->with('model',$invoice);
    }

    public function handler($no, PaymentRequest $request){

        $invoice = Invoice::with('client','items')->where('no_inv',$no)->first();
        $totalz = 0;
        //signature
        $requestDate = Carbon::now()->toIso8601ZuluString();
        $targetPath = "/checkout/v1/payment";
        $requestID = $invoice->client->code.Carbon::now()->format('dmYHis');
        
        $itemCart = [];
        foreach($invoice->items as $item){
            if($item->qty_type == "HOURLY"){
            $price = $item->adjustment ? $item->price - ($item->adjustment/ $item->qty) : $item->price;
            $usedPrice = $price/100;
            $qty = $item->qty*100;
                
            }
            
            $itemCart [] = array(
                'sku' => $item->item_name,
                'name' => $item->note ? $item->note : $item->item_name,
                'price' => $usedPrice,
                'quantity' => $qty
            );
            $totalz += ($price*$item->qty);
        }
        $itemList = json_encode($itemCart);
        $body = [
                "order" => [
                    "amount" => $invoice->total,
                    "invoice_number" => $invoice->no_inv,
                    "currency"=>"IDR",
                    "session_id"=> $requestID,
                    "line_items"=> $itemCart,
                    "callback_url"=> route('invoice.payment',strtolower($invoice->no_inv)),
                    "failed_url"=> route('invoice.payment',strtolower($invoice->no_inv)),
                    "auto_redirect"=> false
                ],
                "customer"=> [
                    "id"=> $invoice->client->id,
                    "name"=> $invoice->client->name,
                    "email"=> $invoice->client->email,
                    "address"=> $invoice->client->address
                ],
                "payment"=> [
                    "payment_due_date"=> 60,
                    "payment_method_types" => [
                        "CREDIT_CARD",
                    ]
                    ],
            ];
        $requestBody = json_encode($body);
        $digestValue = base64_encode(hash('sha256', $requestBody, true));
        $componentSignature = "Client-Id:".$this->clientID ."\n". 
                      "Request-Id:".$requestID . "\n".
                      "Request-Timestamp:".$requestDate ."\n". 
                      "Request-Target:".$targetPath ."\n".
                      "Digest:".$digestValue;
        // Calculate HMAC-SHA256 base64 from all the components above
        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $this->secretKey, true));
        
        // dd($signature);
            $response = Http::withHeaders([
                'Client-Id'=>  $this->clientID,
                'Request-Id'=> $requestID,
                'Request-Timestamp'=> $requestDate,
                'Signature'=> 'HMACSHA256='.$signature
                ])->post($this->urlPoint.$targetPath,$body);

            $dataPayment = ['references_code'=>$requestID,
                'id_invoice'=>$invoice->id,
                'method'=>'CREDIT CARD',
                'total_amount'=>$invoice->total,
                'fee_merchant'=>0,
                'fee_customer'=>0,
                'total_fee'=>0,
                'amount_received'=>$invoice->total,
                'status'=>"PENDING"];
            
            Payment::create($dataPayment);
            // dd($response->json());

                if($response->status() !== 200){
                dd("TTZ:".$totalz,"INV TOTAL:".$invoice->total,$itemCart,$response->json());
                return redirect()->route('invoice.payment',strtolower($invoice->no_inv))
                ->with('failed',"Something went wrong, please contact our administrator at contact@algoseabiz.com");}
                // dd($response->json());

        return redirect($response['response']['payment']['url']);
    }

    public function callbackHandler(Request $request){
        if($request->transaction['status'] == "SUCCESS"){
        $paymentData = Payment::where('references_code',$request->transaction['original_request_id'])->first();
        $paymentData->status = "SUCCESS";
        $paymentData->save();

        $invoice = Invoice::findOrFail($paymentData->id_invoice);
        $invoice->status = "PAID";
        $invoice->paid_at = Carbon::parse($request->transaction['date'])->format('Y-m-d H:i:s');
        $invoice->save();
        }

        // print_r($request->toArray());
        // echo "<br>";
        // print_r($_POST);
        // print_r($request->transaction['status']);

        return "CONTINUE";
    }

    }
