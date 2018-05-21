@extends('layouts.app')

@section('content')
<div class="content-wrapper">
     <table class="table table-bordered" id="serverDataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>                
            </tr>
        </thead>
<!--        <tbody>
            <tr>
                <td>Name</td>
                <td>Email</td>                
            </tr>
        </tbody>-->
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
        "scrollX": true,
        "buttons": ['excel','pdf','print', 'pageLength'],
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

