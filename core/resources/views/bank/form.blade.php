
  @extends('layouts.app', ['activePage' => 'BankForm', 'titlePage' => __('Bank'),'pageSlug' => __('bank')])
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <form method="post" enctype="multipart/form-data" action="{{ $model->exists ? route('bank.update',$model->id):route('bank.store')}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method($model->exists ? "PUT" : 'POST')
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title">Add Item</h4>
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
                    <a href="{{route('bank.index')}}" class="btn btn-sm btn-primary">Back to list</a>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                    <label class="col-sm-12">Bank Name</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="bank_name" id="input-bank_name" placeholder="ex: Bank Central Asia"  type="text" value="{{ $model ?  $model->bank_name : old('bank_name') }}" required="true" 
                        aria-required="true">
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="col-sm-12">Bank Number</label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="bank_number" id="input-bank_number" type="text" value="{{ $model ? $model->bank_number : old('bank_number') }}" required="true"  required="true" aria-required="true">
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="col-sm-12">Swift Code </label>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" name="bank_swift" id="input-bank_swift" type="text"  value="{{ $model ? $model->bank_swift : old('bank_swift') }}" required="true"  required="true" aria-required="true">
                    </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="" class="col-md-12">Bank Account Name</label>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="text" name="bank_holder_name" id="input-bank_holder_name" placeholder="ex: John Doe" class="form-control" value="{{ $model ? $model->bank_holder_name : old('bank_holder_name') }}" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label class="col-sm-12">Bank Code</label>
                  <div class="col-sm-12">
                  <div class="form-group">
                      <input class="form-control" name="bank_code" id="input-bank_code" type="text" placeholder="ex:014" value="{{ $model ? $model->bank_code : old('bank_code') }}" required="true"  required="true" aria-required="true">
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="col-sm-12">Bank Shortname</label>
                  <div class="col-sm-12">
                  <div class="form-group">
                      <input class="form-control" name="shortname" id="input-shortname" type="text" placeholder="ex: BCA" value="{{ $model ?  $model->shortname : old('shortname') }}" required="true"  required="true" aria-required="true">
                  </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="col-md-12">Status</label>
                  <div class="col-sm-12">
                    <select name="status" class="form-control">
                      <option value="active" {{ $model->status == "active" || !$model->status ? "selected" : false}}>Active</option>
                      <option value="deactive" {{ $model->status == "deactive" ? "selected" : false}}>Deactive</option>
                    </select>
                  </div>
                </div>
            </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn">{{$model->exists ? "Update Data" : "Add Item"}}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
@endpush
