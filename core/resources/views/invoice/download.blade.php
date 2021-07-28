
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Download Invoice  </title>
  <!-- Fonts -->
  <!-- Icons -->
  <style>
    body{
      font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
  .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
  }
  .table th,
  .table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #eceeef;
  }
  .table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #eceeef;
  }
  .table tbody + tbody {
    border-top: 2px solid #eceeef;
  }
  .table .table {
    background-color: #fff;
  }
  .table-sm th,
  .table-sm td {
    padding: 0.3rem;
  }
  .table-bordered {
    border: 1px solid #eceeef;
  }
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #eceeef;
  }
  .table-bordered thead th,
  .table-bordered thead td {
    border-bottom-width: 2px;
  }
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
  }
  .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
  }
  .table-active,
  .table-active > th,
  .table-active > td {
    background-color: rgba(0, 0, 0, 0.075);
  }
  .table-hover .table-active:hover {
    background-color: rgba(0, 0, 0, 0.075);
  }
  .table-hover .table-active:hover > td,
  .table-hover .table-active:hover > th {
    background-color: rgba(0, 0, 0, 0.075);
  }
  .table-success,
  .table-success > th,
  .table-success > td {
    background-color: #dff0d8;
  }
  .table-hover .table-success:hover {
    background-color: #d0e9c6;
  }
  .table-hover .table-success:hover > td,
  .table-hover .table-success:hover > th {
    background-color: #d0e9c6;
  }
  .table-info,
  .table-info > th,
  .table-info > td {
    background-color: #d9edf7;
  }
  .table-hover .table-info:hover {
    background-color: #c4e3f3;
  }
  .table-hover .table-info:hover > td,
  .table-hover .table-info:hover > th {
    background-color: #c4e3f3;
  }
  .table-warning,
  .table-warning > th,
  .table-warning > td {
    background-color: #fcf8e3;
  }
  .table-hover .table-warning:hover {
    background-color: #faf2cc;
  }
  .table-hover .table-warning:hover > td,
  .table-hover .table-warning:hover > th {
    background-color: #faf2cc;
  }
  .table-danger,
  .table-danger > th,
  .table-danger > td {
    background-color: #f2dede;
  }
  .table-hover .table-danger:hover {
    background-color: #ebcccc;
  }
  .table-hover .table-danger:hover > td,
  .table-hover .table-danger:hover > th {
    background-color: #ebcccc;
  }
  .thead-inverse th {
    color: #fff;
    background-color: #292b2c;
  }
  .thead-default th {
    color: #464a4c;
    background-color: #eceeef;
  }
  .table-inverse {
    color: #fff;
    background-color: #292b2c;
  }
  .table-inverse th,
  .table-inverse td,
  .table-inverse thead th {
    border-color: #fff;
  }
  .table-inverse.table-bordered {
    border: 0;
  }
  .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -ms-overflow-style: -ms-autohiding-scrollbar;
  }
  .table-responsive.table-bordered {
    border: 0;
  }
  .text-right{
      text-align:right;
  }
  .text-left{
      text-align:left;
  }
  .btn {
    display: inline-block;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 11px 40px;
    padding-top: 11px;
    padding-right: 40px;
    padding-bottom: 11px;
    padding-left: 40px;
    font-size: 0.875rem;
    line-height: 1.35em;
    border-radius: 0.25rem;
  }
  .btn-danger{
      background-color:red;
      color:#FFF;
  }
  .btn-primary{
    background-color:green;
    color:#FFF;
  }
  .bank-info:not(:last-child){
    border-right:1px solid #000;
  }
  .bank-info:not(:first-child){
    margin-left:25px;
  }
  .bank-info-wrapper:nth-child(even){
    margin-left:200px;
  }
  .bank-info-wrapper:nth-child(1){
    background:#000;
    margin-left:200px;
  }
  .page-break{
    page-break-after: always;
  }
    </style>
</head>
<body class="bg-dark" >
    <div class=""  style="max-width:100%; margin:25px auto;padding:20px;">
  <div class="header py-7 py-lg-8">
    <div class="container py-4">
        <div class="col-12 mt-2">
            <table style="width:100%;border:0px solid #000;">
                <tr>
                    <td style="border:0px solid #000;"><img src="{{asset('black')}}/img/logo.png" class="img-fluid"></td>
                    
                    <td style="border:0px solid #000;" class="text-right"><button style="margin-left:285px;" class="btn  {{ $model->status == "ONHOLD" ? "btn-danger" : "btn-primary"}}"><strong>{{$model->status}}</strong></button></td>
                </tr>
            </table>
                        </div>
                    </div>
                   <table style="width:100%;margin-top:15px;">
                    <tr>
                    <td colspan="3" style="text-align:left;"><h3>{{$model->no_inv}}
                      <small style="font-size:12px;color:red;margin-left:15px;">#All Invoice value are in Indonesian Rupiah</small></h3> </td>
                    <tr style="border:1px solid #000;">
                      <td>  
                        <strong>{{$model->name}}</strong><br>
                      </td>
                      <td>
                        Created at: <strong>{{\Carbon\Carbon::parse($model->created_at)->format('d F Y')}}</strong><br>
                      </td>
                      <td>
                       
                        Address: <strong>{{$model->address}}</strong><br>
                      </td>
                    </tr>
                    <tr >
                      <td >  
                        PIC: <strong>{{$model->pic_name}}</strong><br>
                      </td>
                      <td>
                        @if($model->status == "ONHOLD")
                        Due Date: <strong>{{\Carbon\Carbon::parse($model->due_date)->format('d F Y') }}</strong><br>
                        @else
                        Paid At: <strong>{{\Carbon\Carbon::parse($model->paid_at)->format('d F Y') }}</strong><br>
                        @endif
                      </td>
                      <td>
                       
                        Phone: <strong>{{$model->phone}}</strong>
                      </td>
                    </tr>
                   </table>
                <div class="card-body" >
                    <div class="">
                        <table class="table tablesorter " id="" style="margin-top:15px;border:1px solid #000;padding:0;">
                            <thead class=" text-primary text-left" style="background:#CCC">
                                <tr>
                                    <th scope="col" class="">No</th>
                                    <th scope="col" style="width:35%">Item</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Price </th>
                                    <th scope="col">Qty</th>
                                    <th scope="col" style="">Adjustment</th>
                                    <th scope="col">Total </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $i)
                                    <tr>
                                        <td class="">{{$loop->iteration}}</td>
                                        <td>{{$i->item_name}} @if($i->item_note)<br><small>({{$i->item_note}})</small>@endif</td>
                                        <td>{{ucwords(strtolower($i->qty_type))}}</td>
                                        <td>{{number_format($i->price)}}</td>
                                        <td>{{number_format($i->qty)}}</td>
                                        <td>{{number_format($i->adjustment)}}</td>
                                        <td>{{number_format($i->total)}}</td>
                                    </tr>
                                @endforeach
                                <tfoot style="background:blue;color:#FFF;">
                                    <tr class="bg-primary text-white">
                                        <td colspan="6">Grand Total : </td>
                                        <td>{{number_format($model->total)}}</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row">
              @if($model->notes)
              Note: <strong>{{$model->notes}}</strong><br><br>
              @endif
              <b>{{$profile->thankyou_message}}</b>
              <br>
              <h3>Payment Info</h3>
                <div class="max-width:100%">
                  
              @foreach($banks as $b)
              <div style="clear:both; position:relative;">
                <div style="position:absolute; left:{{$loop->iteration%2 == 0 ? 300 : 0 }}pt; width:50%;{{$loop->iteration>=3 ? "top:100px;":false}}" class="bank-info-wrapper bank-info">
                    
                    Name Of Bank:
                    <span style="text-transform:capitalize">{!! strtolower($b->bank_name)."<span style='text-transform:uppercase'>(".strtolower($b->shortname).")</span>"!!}</span>
                  <br>
                    Bank Holder:
                    <span>{{ ucwords($b->bank_holder_name)}}<span>
                  <br>
                  Account Number:
                    <span>{{$b->bank_number}}</span>
                  <br>
                    Bank Code:
                    <span>{{$b->bank_code}}</span>
                  <br>
                    Swift Code:
                    <span>{{$b->bank_swift}}</span>
                </div>
            </div>
            @if($loop->iteration%2 == 0)
            <br>
            @endif
             
              @endforeach
            </div>
            
            <div style="margin-top:25px;display:block;position:absolute;bottom:0;">
              <b>NPWP: {{$profile->tax_id}}</b>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>