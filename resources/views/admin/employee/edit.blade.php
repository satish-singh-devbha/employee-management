@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Employee') }}</div>

                <div class="card-body text-center">

                    <form id="form_data">
                        
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="uid" value="{{ $data->id }}">
                        <input type="hidden" name="uaid" value="{{ $data->userAddress->id }}">

                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" id="employeeId" name="employeeId" placeholder="Employee ID" value="{{ $data->employee_id }}" disabled>
                            </div>

                            <div class="col">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $data->name }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data->email }}" disabled>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="buildingNo" name="buildingNo" placeholder="Building No" value="{{ $data->userAddress->building_no }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" id="streetName" name="streetName" placeholder="Street Name" value="{{ $data->userAddress->street_name }}">
                            </div>

                            <div class="col">
                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="{{ $data->userAddress->pincode }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select Country</option>
                                    
                                </select>
                            </div>
                            <div class="col">
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select State</option>
                                    
                                </select>
                            </div>
                            <div class="col">
                                <select name="city" id="city" class="form-control">
                                    <option value="">Select City</option>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-primary edit_employee">Submit</button>
                    </form>
                    
                    <div><span class="text-danger">*</span> Please select first country then state then city order.</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection



@section("scripts")
<script>

    $(document).ready(function() {
        // Fetch countries data via AJAX
        $.ajax({
            url: '/admin/country',
            method: 'GET',
            success: function(data) {
                let countriesSelect = $('#country');
                countriesSelect.empty().append('<option value="">Select Country</option>');

                data.forEach(function(country) {
                    let selected = false;
                    if(country.name == "{{ $data->userAddress->countryFunc->name }}") {
                        selected = true;
                    }

                    selected = (selected) ? 'selected' : '';
                    
                    if(selected) {
                        state(country.id);
                    }
                    countriesSelect.append('<option value="' + country.id + '" '+ selected +' >' + country.name + '</option>');
                });

                

            },
            error: function(err) {
                console.error('Error fetching countries:', err);
            }
        });

        // Handle change event for country select
        $('#country').on("change", state);
        
        function state(val) {

            let selectedCountry = val;
            if(val && val.currentTarget) {
                selectedCountry = $(this).val();
            }

            let statesSelect = $('#state');
            statesSelect.empty().append('<option value="">Select State</option>');

            if (selectedCountry) {

                $.ajax({
                    url: '/admin/state/' + selectedCountry,
                    method: 'GET',
                    success: function(data) {
                     
                        data.forEach(function(state) {

                            if(state.id == Number("{{ $data->userAddress->state }}")) {
                                statesSelect.append('<option value="' + state.id + '" selected>' + state.name + '</option>');

                                city(state.id);
                            } else {
                                statesSelect.append('<option value="' + state.id + '">' + state.name + '</option>');
                            }

                            
                        });
                        statesSelect.prop('disabled', false);
                    },
                    error: function(err) {
                        console.error('Error fetching states:', err);
                    }
                });
            } else {
                statesSelect.prop('disabled', true);
            }
        }

        // Handle change event for state select
        $('#state').on("change", city);

        function city(val) {

            let selectedState = val;

            if(val && val.currentTarget) {
                selectedState = $(this).val();
            }
            
            let citiesSelect = $('#city');
            citiesSelect.empty().append('<option value="">Select City</option>');

            if (selectedState) {
                $.ajax({
                    url: '/admin/city/' + selectedState,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(city) {

                            if(city.id == Number("{{ $data->userAddress->city }}")) {
                                citiesSelect.append('<option value="' + city.id + '" selected>' + city.name + '</option>');
                            } else {
                                citiesSelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                            }                            
                        });
                        citiesSelect.prop('disabled', false);
                    },
                    error: function(err) {
                        console.error('Error fetching cities:', err);
                    }
                });
            } else {
                citiesSelect.prop('disabled', true);
            }
        }

        $(".edit_employee").on("click", function() {
            let self = $(this);
            let elm = ["employeeId", "name", "email", "buildingNo", "streetName", "pincode", "password", "confirmPassword", "country", "state", "city"];

            $(".form_input_employee").find(".alert").remove();

            $.each(elm, function(index, value) {
                $("#"+value).removeClass('is-invalid valid');
            });

            $.ajax({
                url: '/admin/employee',
                method: 'POST',
                data: $("#form_data").serialize(),
                success: function(data) {
                    
                    if(data.hasOwnProperty("success")) {
                        window.location.href = "/employees"
                    }
                },
                error: function(err) {

                    if(err.hasOwnProperty("responseJSON") && err.responseJSON.hasOwnProperty("errors")) {

                        $.each(err.responseJSON.errors, function(index, value) {
                            $("#"+index).next().remove('.alert');

                            $("#"+index).addClass('is-invalid');
                            $("#"+index).after('<div class="alert alert-danger p-0">'+ value[0] +'</div>');
                        });

                    }
                }
            });


        });
        
    });

</script>

@endsection