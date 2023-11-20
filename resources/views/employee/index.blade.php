@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <span>{{ __('Employees List') }}</span> 

                    @is_admin
                        <a href="/admin/employee/create" class="btn btn-primary" style="margin-left: auto">Add Employee</a>
                    @endis_admin
                  
                </div>

                <div class="card-body">
         

                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {

        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.show') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'employee_id', name: 'employee_id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        table.buttons().destroy();

        $('.data-table').on('click', '.delete', function() {
            let employeeID = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/admin/employee/' + employeeID,
                    type: 'DELETE',
                    success: function(data) {
                        alert("Employee Record Deleted Successfully");

                        table.ajax.reload();
                    }
                });
            }
        });
        
    });
  </script>
@endsection
