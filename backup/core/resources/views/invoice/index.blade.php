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
                </div>
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
                                        <td>{{ $loop->iteration }}</td>
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
@endpush
