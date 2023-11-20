@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Employees List') }}</div>

                <div class="card-body ">
         
                    <h3>Welcome To Employee Dashboard Section: {{ Auth::user()->name }}</h3>  

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
