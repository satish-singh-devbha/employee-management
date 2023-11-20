@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Section') }}</div>

                <div class="card-body text-center">
         
                    <h3>Welcome To Admin Dashboard Section</h3>        
                    
                    {{-- <a href="/employees" class="btn btn-primary">view employee lists</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
