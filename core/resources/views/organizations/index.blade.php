@extends('layouts.app', ['activePage' => 'Organization', 'titlePage' => __('Organization'),'pageSlug' => __('organizations')])
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Organization Profile') }}</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ route('organization.update', $organization->id) }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success mt-3">
                                {{ $message }}
                            </div>
                        @endif

                        @if ($message = Session::get('failed'))
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
                        <div class="row mb-2">
                            <label class="col-sm-12 col-form-label">Logo</label>
                            <div class="col-sm-3">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div>
                                        <input class="btn btn-file text-left" type="file" name="logo" id="input-picture">
                                    </div>

                                    <div class="fileinput-new d-none">
                                        <img src="#"
                                            class="img-thumbnail" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Organization/Company Name') }}</label>
                            <input type="text" name="company_name" class="form-control" placeholder="{{ __('Name') }}"
                                value="{{ old('name', $organization->company_name) }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="{{ __('Phone') }}"
                                value="{{ old('phone', $organization->phone_number) }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Tax ID') }}</label>
                            <input type="text" name="tax_id" class="form-control" placeholder="{{ __('Name') }}"
                                value="{{ old('tax_id', $organization->tax_id) }}">
                        </div>

                        <div class="form-group">
                            <label>{!! __('Thankyou Message <small>(put your message for the invoice)</small>') !!}</label>
                            <textarea name="thankyou_message" class="form-control" placeholder="{{ __('Ex: Thankyou for trusting us as your partner...') }}"
                            >{{ old('thankyou_message', $organization->thankyou_message) }}</textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <a href="#">
                            <img class="img-fluid img-thumbnail mb-3" src="{{ asset('organization')}}/{{$organization->logo ? $organization->logo : 'logo.png' }}" alt="" width="250px">
                            <h3 class="title">{{ $organization->company_name }}</h3>
                        </a>
                    </div>
                    </p>
                    <div class="card-description text-center">
                        {{ $organization->phone_number ." - ". $organization->tax_id}}<br>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- <div class="button-container">
                        <button class="btn btn-icon btn-round btn-facebook">
                            <i class="fab fa-facebook"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-google">
                            <i class="fab fa-google-plus"></i>
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
