@extends('layouts.app', ['activePage' => 'bank', 'titlePage' => __('Banks'),'pageSlug' => __('bank')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h4 class="card-title">Bank</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('bank.create')}}" class="btn btn-sm btn-primary">Add Bank</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive min-vh-100">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Bank Number</th>
                                    <th scope="col">Holder Name</th>
                                    <th scope="col">Swift Code</th>
                                    <th scope="col">Bank Code</th>
                                    <th scope="col">Create Date</th>
                                    <th scope="col">Last Update</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $m)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{$m->bank_name}} <small class="text-uppercase">({{$m->shortname}})<small></td>
                                        <td>{{ $m->bank_number }}</td>
                                        <td  class="text-capitalize">{{ $m->bank_holder_name }}</td>
                                        <td class="text-uppercase">{{ $m->bank_swift }}</td>
                                        <td>{{ $m->bank_code }}</td>
                                        <td>{{ $m->created_at->format('d F Y H:i:s') }}</td>
                                        <td>{{ $m->updated_at->format('d F Y H:i:s') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('bank.edit',$m->id)}}">Edit</a>
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
                    {{ $banks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
