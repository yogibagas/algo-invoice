@extends('layouts.app', ['activePage' => 'Invoice', 'titlePage' => __('Invoice'),'pageSlug' => __('invoices')])

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h4 class="card-title">Invoices</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('invoice.create')}}" class="btn btn-sm btn-primary">Add invoice</a>
                        </div>
                    </div>
                    <form>
                    <div class="row ">
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                            <label for="" class="">Client</label>
                                <select name="filter[client]" id="" class="form-control bg-info">
                                    <option value="">All Client</option>
                                    @foreach($client as $cl)
                                    <option value="{{$cl->id}}" {{isset($_GET['filter']['client']) ? $_GET['filter']['client'] == $cl->id ? "selected":false :false}}>{{$cl->name."-".$cl->pic_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <label for="">Due Date</label>
                            <input type="text" class="form-control bg-info" name="filter[due_date]" id="due_date" readonly autocomplete="off" value="{{isset($_GET['filter']['client']) ? $_GET['filter']['due_date']? $_GET['filter']['due_date'] : false:false }}">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Status</label>
                            <select name="filter[status]" id="" class="form-control bg-info">
                                <option value="">All</option>
                                <option value="ONHOLD" {{isset($_GET['filter']['client']) ? $_GET['filter']['status'] == "ONHOLD" ? "selected":false:false}}>ONHOLD</option>
                                <option value="PAID" {{isset($_GET['filter']['client']) ?$_GET['filter']['status'] == "PAID" ? "selected":false:false}}>PAID</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Total</label>
                            <select name="filter[total]" id="" class="form-control bg-info">
                                <option value="" >Default</option>
                                <option value="DESC" {{isset($_GET['filter']['client']) ?$_GET['filter']['total'] == "DESC" ? "selected":false:false}}>Highest</option>
                                <option value="ASC" {{isset($_GET['filter']['client']) ?$_GET['filter']['total'] == "ASC" ? "selected":false:false}}>Lowest</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-right">
                            <button class="btn btn-info mt-4">Apply Filter</button>
                        </div>
                    </div>
                </div>
            </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Invoice No</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Total Item</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $c)
                                    <tr>
                                        <td>{{ $loop->iteration+ $model->firstItem() - 1 }}</td>
                                        <td>{{$c->no_inv}}</td>
                                        <td>{{ $c->client->name }}</td>
                                        
                                        <td>{{ $c->items_count }} Item{{$c->items_count > 1 ? "s":false}}</td>
                                        <td>{{ number_format($c->total,0,0,".") }}</td>
                                        <td> <span class="{{$c->status == "ONHOLD" ? "text-danger" : "text-info"}}">{{$c->status}}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($c->due_date)->format('d F Y') }}</td>
                                        <td>{{ $c->created_at->format('d F Y H:i:s') }} <br> 
                                            <small>last update: {{$c->updated_at->format('d F Y H:i:s')}}</small>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('invoice.edit',$c->id)}}">Edit</a>
                                                    <a class="dropdown-item" href="{{route('invoice.payment',strtolower($c->no_inv))}}" target="_blank">Visit Link Payment</a>
                                                    <a class="dropdown-item" href="{{route('invoice.download',strtolower($c->id))}}" target="_blank">Download</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $model->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<input type="text" name="daterange" value="01/01/2018 - 01/15/2018" />

<script>
$(function() {
    $('#due_date').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('#due_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('#due_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>
@endpush
