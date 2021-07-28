
  @extends('layouts.app', ['activePage' => 'ClientForm', 'titlePage' => __('Clients'),'pageSlug' => __('clients')])
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <form method="post" enctype="multipart/form-data" action="{{ $client->exists ? route('client.update',$client->id):route('client.store')}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method($client->exists ? "PUT" : 'POST')
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title">Add Item</h4>
                @if ($message = Session::get('success'))
                <div class="alert alert-success mt-3">
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
                @if($message = Session::get('failed'))
                <div class="alert alert-danger mt-3">
                    {{ $message }}
                </div>
                @endif
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 text-right mb-4">
                    <a href="{{route('client.index')}}" class="btn btn-sm btn-primary">Back to list</a>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                    <label class="col-sm-12">Name</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="name" id="input-name" type="text" placeholder="Name" value="{{ $client ?  $client->name : old('name') }}" required="true" 
                        aria-required="true">
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="col-sm-12">Pic Name</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="pic_name" id="input-pic" type="text" placeholder="Pic Name" value="{{ $client ? $client->pic_name : old('pic_name') }}" required="true"  required="true" aria-required="true">
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="col-sm-12">Client Code <small>(used for invoice purpose)</small></label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="code" id="input-code" type="text" placeholder="Client Code" value="{{ $client ? $client->code : old('code') }}" required="true"  required="true" aria-required="true">
                    </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="col-sm-12">Address</label>
                  <div class="col-sm-12">
                  <div class="form-group">
                      <input class="form-control" name="address" id="input-address" type="text" placeholder="Address" value="{{ $client ? $client->address : old('address') }}" required="true"  required="true" aria-required="true">
                  </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="col-sm-12">Phone</label>
                  <div class="col-sm-12">
                  <div class="form-group">
                      <input class="form-control" name="phone" id="input-phone" type="text" placeholder="Phone" value="{{ $client ?  $client->phone : old('phone') }}" required="true"  required="true" aria-required="true">
                  </div>
                  </div>
                </div>
            </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn">{{$client->exists ? "Update Data" : "Add Item"}}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
@endpush
