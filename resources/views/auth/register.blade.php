@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @php
                        $items1 = [
                            //                 name     isRequired   type
                            "* Borrower Role" => ["borrower_role_id", "required", "dropdown"],
                            "* Firstname" => ["firstname", "required", "text"],
                            "Middlename" => ["middlename", "", "text"],
                            "* Lastname" => ["lastname", "required", "text"],
                            "* Gender" => ["gender", "required", "dropdown"],
                        ];
                        $items2 = [
                            //                 name     isRequired   type
                            "* Course" => ["course", "required", "dropdown"],
                            "* Year" => ["year", "required", "text"],
                            "* Section" => ["section", "required", "text"],
                        ];
                        $items3 = [
                            //                 name     isRequired   type
                            "* Contact No." => ["contact_no", "required", "number"],
                            "* Birthday" => ["birthday", "required", "date"],
                            "* Username" => ["username", "required", "text"],
                            "* Email" => ["email", "required", "text"],
                            "* Password" => ["password", "required", "password"],
                        ];
                    @endphp

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    @foreach ($items1 as $label => [$name, $isRequired, $type])
                                        <div class="form-group row">
                                            <label for="{{ $name }}" class="col-md-3 col-form-label text-md-right">{{ $label }}</label>
                                            <div class="col-md-9">
                                                @if ($type == "dropdown")
                                                    <select onchange="selectedRole()" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}">
                                                        @if ($name == "borrower_role_id")
                                                            <option value="" disabled selected>Select Borrower Role</option>
                                                            <option value="1">Student</option>
                                                            <option value="2">Faculty</option>
                                                        @elseif ($name == "gender")
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
                                    <div id="student-info">
                                        @foreach ($items2 as $label => [$name, $isRequired, $type])
                                            @if ($type == "dropdown")
                                                <div class="form-group row">
                                                    <label for="{{ $name }}" class="col-md-3 col-form-label text-md-right">{{ $label }}</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}">
                                                            <option value="BSCS">BSCS</option>
                                                            <option value="BSIT">BSIT</option>
                                                            <option value="HRM">HRM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <div class="form-group row">
                                            @foreach ($items2 as $label => [$name, $isRequired, $type])
                                                @if ($type == "text")
                                                    <label for="{{ $name }}" class="col-3 col-form-label text-md-right" >{{ $label }}</label>
                                                    <div class="col-3">
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
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

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

@section('js')
    <script>
        function selectedRole() {
            let role = document.getElementById("borrower_role_id");
            let selected_role = role.value;
            let student_element = document.getElementById("student-info");

            if (selected_role == 1) {
                student_element.style.display = "block";
            } else {
                student_element.style.display = "none";
            }
        }
    </script>
@endsection
