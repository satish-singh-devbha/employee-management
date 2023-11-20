@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Employee') }}</div>

                <div class="card-body text-center">

                    <form id="form_data">
                        <div class="row mb-3">
                            <div class="col form_input_employee">
                                <input type="text" class="form-control" id="employeeId" name="employeeId" placeholder="Employee ID">
                            </div>

                            <div class="col form_input_employee">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form_input_employee">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="col form_input_employee">
                                <input type="text" class="form-control" id="buildingNo" name="buildingNo" placeholder="Building No">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form_input_employee">
                                <input type="text" class="form-control" id="streetName" name="streetName" placeholder="Street Name">
                            </div>

                            <div class="col form_input_employee">
                                <input type="number" class="form-control" id="pincode" name="pincode" placeholder="Pincode" maxlength="10">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form_input_employee">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="col form_input_employee">
                                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <div class="col form_input_employee">
                                <select name="country" id="country" class="form-control">
                                    <<option value="">Select Country</option>
                                </select>
                            </div>
                            <div class="col form_input_employee">
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col form_input_employee">
                                <select name="city" id="city" class="form-control">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-primary add_employee">Submit</button>
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
                var countriesSelect = $('#country');
                countriesSelect.empty().append('<option value="">Select Country</option>');
                data.forEach(function(country) {
                    countriesSelect.append('<option value="' + country.id + '">' + country.name + '</option>');
                });
            },
            error: function(err) {
                console.error('Error fetching countries:', err);
            }
        });

        // Handle change event for country select
        $('#country').on("change", function() {
            var selectedCountry = $(this).val();
            var statesSelect = $('#state');
            statesSelect.empty().append('<option value="">Select State</option>');

            if (selectedCountry) {
                $.ajax({
                    url: '/admin/state/' + selectedCountry,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(state) {
                            statesSelect.append('<option value="' + state.id + '">' + state.name + '</option>');
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
        });

        // Handle change event for state select
        $('#state').on("change", function() {
            var selectedState = $(this).val();
            var citiesSelect = $('#city');
            citiesSelect.empty().append('<option value="">Select City</option>');

            if (selectedState) {
                $.ajax({
                    url: '/admin/city/' + selectedState,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(city) {
                            citiesSelect.append('<option value="' + city.id + '">' + city.name + '</option>');
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
        });

        $(".add_employee").on("click", function() {
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
                    alert("Successfully Employee Added!");

                    window.location.href = "/employees";
                },
                error: function(err) {
                    console.error('Error fetching cities:', err);
                    

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