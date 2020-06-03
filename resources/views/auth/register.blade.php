@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @php
                        $items = [
                            //                 name     isRequired   type
                            "* Username" => ["username", "required", "text"],
                            "* Email" => ["email", "required", "text"],
                            "* Password" => ["password", "required", "password"],
                            "* Firstname" => ["firstname", "required", "text"],
                            "Middlename" => ["middlename", "", "text"],
                            "* Lastname" => ["lastname", "required", "text"],
                            "* Gender" => ["gender", "required", "dropdown"],
                            "* Contact No." => ["contact_no", "required", "number"],
                            "* Birthday" => ["birthday", "required", "date"],
                            "* Username" => ["username", "required", "text"],
                        ]
                    @endphp

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @foreach ($items as $label => [$name, $isRequired, $type])


                            <div class="form-group row">
                                <label for="{{ $name }}" class="col-md-4 col-form-label text-md-right">{{ $label }}</label>

                                <div class="col-md-6">
                                    @if ($type == "dropdown")
                                        <select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}">
                                            @if ($name == "gender")
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            @endif
                                        </select>
                                        @error($name)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @else
                                        <input type="{{ $type }}"
                                            class="form-control @error($name) is-invalid @enderror"
                                            name="{{ $name }}"
                                            id="{{ $name }}"
                                            value="{{ old($name) }}"
                                        >
                                        @error($name)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
