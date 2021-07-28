
  @extends('layouts.app', ['activePage' => 'InvoiceForm', 'titlePage' => __('Invoice'),'pageSlug' => __('invoices')])
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="post" enctype="multipart/form-data" action="{{ $model->exists ? route('invoice.update',$model->id):route('invoice.store')}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method($model->exists ? "PUT" : 'POST')
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title">New Invoice </h4>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 text-right mb-4">
                    <a href="{{route('invoice.index')}}" class="btn btn-sm btn-primary">Back to list</a>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                    <label class="col-sm-12">Select Client</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control text-warning" name="client_id" id="select-client" readonly="">
                          @if($model->exists)
                          <option value="{{$model->client_id}}" {{$model->client_id == $model->client_id ? "selected":false }}>{{$model->client->name}} - {{ $model->client->pic_name}}</option>
                          @else
                          <option value="">-- Choose client here</option>
                            @foreach($client as $c)
                            <option value="{{$c->id}}" {{$c->id == $model->client_id ? "selected":false }}>{{$c->name}} - {{ $c->pic_name}}</option>
                            @endforeach
                          @endif
                        </select>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label class="col-sm-12">Invoice No</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control text-warning" name="no_inv" readonly id="input-no_inv" type="text" placeholder="" value="{{ $model ? $model->no_inv : old('no_inv') }}" required="true"  required="true" aria-required="true">
                    </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label class="col-sm-12">Status </label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control" name="status" id="input-status" {{$model->status == "PAID" ? "readonly" : false}}>
                          <option value="ONHOLD" {{$model->status == "ONHOLD"? "selected":false}} {{$model->status == "PAID" ? "hidden" : false}} >ONHOLD</option>
                          <option value="PAID" {{$model->status =="PAID" ? "selected" : false}}>PAID</option>
                        </select>
                    </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="col-sm-12">Due Date</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input type="date" name="due_date" class="form-control" value="{{ $model->exists ? \Carbon\Carbon::parse($model->due_date)->format('Y-m-d') : date('Y-m-d', strtotime('+7 days'))}}">
                        
                    </div>
                    </div>
                  </div>
                  <div class="col-md-3" id="paid_at">
                    <label class="col-sm-12">Paid At</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input type="date" name="paid_at" class="form-control" value="{{ $model->exists ? \Carbon\Carbon::parse($model->paid_at)->format('Y-m-d') : ''}}">
                    </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">Item List
                    </div>
                    <div id="item-loop-wrapper">
                    @if(!$model->exists)
                    <div class="card-body">
                      <div class="card loop-wrapper">
                        <div class="card-header">
                          <div class="row">
                            <span class="col-8">Invoice Item </span>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-2 col-md-3">
                              <div class="form-group">
                                <label for="">Item Name*</label>
                                <input type="text" class="form-control" name="item_name[]" value="" {{$model->status == "PAID" ? "readonly":false}}>
                              </div>
                            </div>
                            <div class="col-2 col-md-2">
                              <div class="form-group">
                                <label for="">Type*</label>
                                <select class="form-control" name="item_qty_type[]"  {{$model->status == "PAID" ? "readonly":false}}>
                                  <option value="FIXED" > Fixed Price</option>
                                  <option value="HOURLY" >Hourly Rates</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-2 col-md-1">
                              <div class="form-group">
                                <label for="">Quantity*</label>
                                <input type="number" name="item_qty[]" value="" min="0" step=".01" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control qty"  {{$model->status == "PAID" ? "readonly":false}}>
                              </div>
                            </div>
                            <div class="col-2 col-md-1">
                              <div class="form-group">
                                <label for="">Item Price*</label>
                                <input type="number" name="item_price[]" value="" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control price"  {{$model->status == "PAID" ? "readonly":false}}>
                              </div>
                            </div>
                            <div class="col-2 col-md-3">
                              <div class="form-group">
                                <label for="">Item Note</label>
                                <input type="text" value="" name="item_note[]" class="form-control">
                              </div>
                            </div>
                            <div class="col-2 col-md-2">
                              <label>Adjustment/Discount(%)</label>
                              <input type="number" name="item_adjustment[]" value="" min="0" step=".01" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control adjustment"  {{$model->status == "PAID" ? "readonly":false}}>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer text-right text-white font-weight-bold">Total : <span class="totalprice"> </span> </div>
                      </div>    
                  </div>
                    @endif
                    @foreach($model->items as $item)
                    <div class="card-body" >
                        <div class="card loop-wrapper" id="loop-wrapper-{{$loop->iteration}}">
                          <div class="card-header">
                            <div class="row">
                              <span class="col-8">Invoice Item </span>
                            <input type="hidden" name="item_id[]" value="{{$item->id}}">
                              @if($loop->iteration > 1 )
                              <span class="col-4 text-right">
                                <a href="#" class="btn-sm btn-danger remove-item" onclick="removeItem({{$loop->iteration}})">X</a>
                              </span>
                              @endif
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-2 col-md-3">
                                <div class="form-group">
                                  <label for="">Item Name*</label>
                                  <input type="text" class="form-control" name="item_name[]" value="{{$model->exists ? $item->item_name : ""}}"  {{$model->status == "PAID" ? "readonly":false}}>
                                </div>
                              </div>
                              <div class="col-2 col-md-2">
                                <div class="form-group">
                                  <label for="">Type*</label>
                                  <select class="form-control" name="item_qty_type[]"  {{$model->status == "PAID" ? "readonly":false}}>
                                    <option value="FIXED" {{$item->qty_type == "FIXED" ? "Selected":false}}> Fixed Price</option>
                                    <option value="HOURLY" {{$item->qty_type == "HOURLY" ? "Selected":false}}>Hourly Rates</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-2 col-md-1">
                                <div class="form-group">
                                  <label for="">Quantity*</label>
                                  <input type="number" name="item_qty[]" min="0" step=".01" value="{{$model->exists ? $item->qty : 1}}" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control qty"  {{$model->status == "PAID" ? "readonly":false}}>
                                </div>
                              </div>
                              <div class="col-2 col-md-1">
                                <div class="form-group">
                                  <label for="">Item Price*</label>
                                  <input type="number" name="item_price[]" value="{{$model->exists ? $item->price : 0}}" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control price"  {{$model->status == "PAID" ? "readonly":false}}>
                                </div>
                              </div>
                              <div class="col-2 col-md-3">
                                <div class="form-group">
                                  <label for="">Item Note</label>
                                  <input type="text" value="{{$item->item_note}}" name="item_note[]" class="form-control"  {{$model->status == "PAID" ? "readonly":false}}>
                                </div>
                              </div>
                              <div class="col-2 col-md-2">
                                <label>Adjustment/Discount(%)</label>
                                <input type="number" name="item_adjustment[]" value="{{$model->exists ? $item->adjustment/($item->price*$item->qty)*100 : 0 }}" onkeyup="calcPrice(this)" onload="calcPrice(this)" class="form-control adjustment"  {{$model->status == "PAID" ? "readonly":false}}>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer text-right text-white font-weight-bold">Total : <span class="totalprice"> {{$model->exists ? $item->total:0}} </span> </div>
                        </div>    
                    </div>
                    @endforeach
                    <div class="col-12 col-md-12">
                      <label>Invoice Notes</label>
                      <textarea name="notes" class="form-control notes border-1" placeholder="{{$model->status == "PAID" ? $model->notes : "put your notes here"}}"  
                        {{$model->status == "PAID" ? "readonly":false}}>{{$model->notes}}</textarea>
                    </div>
                  </div>
                    <div class="card-footer items-align-center ">
                      @if($model->status !== "PAID")
                      <div class="row">
                        <div class="col-12">
                          <div class="alert alert-danger" >
                            Item Notes if the item type is <strong>HOURLY RATE</strong>*
                            <ul>
                              <li>Please put total <b>HOURS</b> Spend in the quantity</li>
                              <li>Please put item price with your hourly rate</li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-12 text-right">
                          <a href="#" id="add-item" class="btn">+ More Item</a>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <div class="col-md-12">
                <div class="row ">
                  <div class="form-group">
                    <h4 for="" class="d-inline-block font-weight-bold text-warning font-size-bg">Total Invoice: </h4>
                    <input type="text" class="bg-transparent border-0 ml-2 d-inline-block font-weight-bold text-white readonly invoice_total text-left" value="{{$model->total ? $model->total : 0}}" readonly name="total" id="input-Gtotal" >
                  </div>
                </div>
              </div>
              <button type="submit" class="btn">{{$model->exists ? "Update Invoice" : "Save Invoice"}}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
  var i = $('.loop-wrapper').length;

  $(document).ready(function(e){
    $("#paid_at").hide();
    @if($model->status == "PAID")
    $("#paid_at").show();
    @endif
    $("#input-status").on('change',function(e){
      if($(this).val() !== "PAID")
        $("#paid_at").hide();
      else
        $("#paid_at").show();
        console.log($(this).val());
    });

    $("#add-item").on('click',function(){
      event.preventDefault();
    i++;
      $("#item-loop-wrapper").append(`
                        <div class="card loop-wrapper" id="loop-wrapper-`+i+`">
                          <div class="card-header">
                            <div class="row">
                              <span class="col-8">Invoice Item </span>
                              <span class="col-4 text-right">
                                <a href="#" class="btn-sm btn-danger remove-item" onclick="removeItem(`+i+`)">X</a>
                              </span>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-2 col-md-3">
                                <div class="form-group">
                                  <label for="">Item Name*</label>
                                  <input type="text" class="form-control" name="item_name[]">
                                </div>
                              </div>
                              <div class="col-2 col-md-2">
                                <div class="form-group">
                                  <label for="">Type*</label>
                                  <select class="form-control" name="item_qty_type[]">
                                    <option value="FIXED"> Fixed Price</option>
                                    <option value="HOURLY">Hourly Rates</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-2 col-md-1">
                                <div class="form-group">
                                  <label for="">Quantity*</label>
                                  <input type="number" value="1" name="item_qty[]" min="0" step=".01" onkeyup="calcPrice(this)" class="form-control qty">
                                </div>
                              </div>
                              <div class="col-2 col-md-1">
                                <div class="form-group">
                                  <label for="">Item Price*</label>
                                  <input type="number" value="0" name="item_price[]" onkeyup="calcPrice(this)" class="form-control price">
                                </div>
                              </div>
                              <div class="col-2 col-md-3">
                                <div class="form-group">
                                  <label for="">Item Note</label>
                                  <input type="text" value="" name="item_note[]" class="form-control">
                                </div>
                              </div>
                              <div class="col-2 col-md-2">
                                <label>Adjustment/Discount(%)</label>
                                <input type="number" name="item_adjustment[]" value="0" onkeyup="calcPrice(this)" class="form-control adjustment">
                              </div>
                            </div>
                          <div class="card-footer text-right text-white font-weight-bold">Total : <span class="totalprice"></span> </div>
                          </div>
                        </div>`)

    });

  //generate invoice no
    $("#select-client").on('change',function(){
      var clientID = $(this).children("option:selected").val();
      $.ajax({
        type: "GET",
        url: clientID+"/generate",
        success: function(res){
          console.log(res);
          $("#input-no_inv").val(res)
        }

      });
    });
  });
  
  function removeItem(i){
    event.preventDefault();
    if(confirm('are you sure want to delete this item?')){
      $('#loop-wrapper-'+i).remove();
      i--;
      // console.log('#loop-wrapper-'+i);
      }
      return i;
  }
  function calcPrice(item){
    var wrapper = $(item).closest('.loop-wrapper');
    var qty = wrapper.find('.qty').val();
    var price = wrapper.find('.price').val();
    var adjustment = wrapper.find('.adjustment').val();
    var subTotal = qty*price;
    var grandTotal = subTotal - (adjustment/100*subTotal);

    wrapper.find('.totalprice').html(grandTotal)
    $(".invoice_total").val(totalInvoice());
    return true;
  }

  function totalInvoice(){
    var totalPerRow = 0;
    var adjustmentPerRow =0;
    var grandTotalPerRow =0;

    var adjustment=0;
    var grandTotal =0;
    $('.loop-wrapper').each( function() {
      totalPerRow = $(this).find(".qty").val() * $(this).find(".price").val();
      adjustmentPerRow =($(this).find(".adjustment").val()/100) * totalPerRow;
      grandTotalPerRow = totalPerRow - adjustmentPerRow;

      grandTotal += grandTotalPerRow;
    });
    // console.log(total,adjustment);
    return grandTotal;
  }

</script>
@endpush
