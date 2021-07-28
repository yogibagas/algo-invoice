@extends('layouts.app',['pageSlug' => 'dashboard'])

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8">
                        <h1 class="text-white">{{ $model->status !== "PAID" ? __('Hello ').$model->client->name : "Your invoice has been paid" }} </h1>
                        <p class="text-lead text-light">
                            {{ __('Below are your invoice details') }}
                        </p>
                    </div>
                    
                </div>
            </div>
            @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                {{ $message }}
            </div>
            @endif

            @if($message = Session::get('failed'))
            <div class="alert alert-danger mt-3">
                {{ $message }}
            </div>
            @endif
            <div class="col-12 mt-2">

                <div class="card px-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{asset('black')}}/img/logo.png" class="img-fluid">
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn  {{ $model->status == "ONHOLD" ? "btn-danger" : "btn-primary"}}">Payment: {{$model->status}}</button>
                            </div>
                        </div>
                        <div class="row mt-4">
                        <div class="col-sm-4">
                            
                            Invoice To: <strong>{{$model->client->name}} - {{$model->client->pic_name}}</strong><br>
                            No#: <strong>{{$model->no_inv}}</strong><br>
                        </div>
                            <div class="col-sm-4">
                                Created at: <strong>{{\Carbon\Carbon::parse($model->created_at)->format('d F Y')}}</strong><br>
                                Due Date: <strong>{{\Carbon\Carbon::parse($model->due_date)->format('d F Y') }}</strong>
                            </div>

                            <div class="col-sm-4">
                                Address: <strong>{{$model->client->address}}</strong><br>
                                Phone: <strong>{{$model->client->phone}}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <tr>
                                        <th scope="col" class="">No</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Price (IDR)</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Adjustment</th>
                                        <th scope="col">Total (IDR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($model->items as $i)
                                        <tr>
                                            <td class="">{{$loop->iteration}}</td>
                                            <td>{{$i->item_name}} @if($i->item_note)<br><small>({{$i->item_note}})</small>@endif</td>
                                            <td>{{ucwords(strtolower($i->qty_type))}}</td>
                                            <td>{{number_format($i->price)}}</td>
                                            <td>{{$i->qty}}</td>
                                            <td>{{number_format($i->adjustment)}}</td>
                                            <td>{{number_format($i->total)}}</td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr class="bg-primary text-white">
                                            <td colspan="6 ml-3">Total : </td>
                                            <td>{{number_format($model->total)}}</td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <span class="text-white p-2">
                                <a href="#" class="text-info text-underline">Read our terms and condition</a> before you doing a payment
                            </span>
                        </div>
                    </div>
                </div>
                @if($model->status !== "PAID")
                <form action="{{route('payment.handler',$model->no_inv)}}" method="POST">
                    {{csrf_field()}}
                    <h2 class="text-center">Select Your Payment below</h2>
                    <div class="row">
                    <div class="col-md-3 ">
                        <div class="selection-wrapper border border-white p-2 mb-3 bg-white ">
                            <label for="CC" class="selected-label">
                                <input type="radio" name="selected_item" value="CC" id="CC">
                                <span class="icon "></span>
                                <div class="selected-content text-dark text-center">
                                    <img src="{{asset('black')}}/img/cc-logo.jpeg" class="img-fluid">
                                    <h4 class="text-dark">Visa/Mastercard</h4>
                                </div>
                            </label>
                        </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Pay </button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection
