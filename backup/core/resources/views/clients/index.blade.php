@extends('layouts.app', ['activePage' => 'ClientIndex', 'titlePage' => __('Clients'),'pageSlug' => __('clients')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h4 class="card-title">Clients</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('client.create')}}" class="btn btn-sm btn-primary">Add Client</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Last Update</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $c)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$c->code}}</td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->pic_name }}</td>
                                        <td>{{ $c->address }}</td>
                                        <td>{{ $c->phone }}</td>
                                        <td>{{ $c->created_at->format('d F Y H:i:s') }}</td>
                                        <td>{{ $c->updated_at->format('d F Y H:i:s') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('client.edit',$c->id)}}">Edit</a>
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
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
