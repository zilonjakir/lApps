@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
    @endif
     <table class="table table-bordered" id="serverDataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th> 
                <th>Action</th>                
            </tr>
        </thead>
    </table>
    
</div>

<script>
//    $(document).ready(function() {
//        $('#serverDataTable').DataTable();
//    } );
$(document).ready(function() {
    var _token = '<?php echo csrf_token() ?>';
    $('#serverDataTable').DataTable({
        
        "dom": 'Bfrtip',
        "bProcessing": true,
        "serverSide":true,
        "iDisplayLength": 10,
        "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
        //"scrollY": "500px",
        //"scrollX": true,
        "buttons": ['excel','pdf','print', 'pageLength'],
        "pageLength": 2,
        "ajax":{
            url: 'serverUser',
            type:"post",
            data:{_token:_token},
            error: function (request, status, error) {
            }
        }
    });
} );
</script>

<!--datatable-->


@endsection

