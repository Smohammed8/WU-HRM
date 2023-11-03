@extends(backpack_view('blank'))


<style>
    body {
        font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;

    }
</style>

@section('content')
<br>
<h4>  <caption>Access Log Data</caption>  </h4> 

<form action="{{ route('truncate') }}" method="GET">
    @csrf
    <button type="submit">Truncate Table</button>
</form>

<hr>
<form method="POST" action="{{ route('logs.bulkDelete') }}">
    @csrf
    @method('DELETE')
 

        <table class="table table-sm">
         
           

            <thead>

                <tr>
                 
                    <th><input type="checkbox" id="select-all"> All</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Browser</th>
                    <th scope="col">Operating System</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                 
                </tr>
            </thead>
            <tbody>

        <!-- Display access logs -->
        @foreach($logs as $log)
            <tr>
                <td>{{ $loop->index }}  <input type="checkbox" name="selected_items[]" value="{{ $log->id }}"> </td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->user_agent }}</td>
                <td>{{ $log->operating_system  }}</td>
                <td>{{ $log->access_time }}</td>
                @if($log->status === 'failed' )
                <td> <span class="badge badge-pill badge-danger border">{{ ucfirst($log->status) }} </span></td>
                @else
                <td><span class="badge badge-pill badge-success border">{{ ucfirst($log->status) }} </span></td>
                @endif

              
               
            </tr>
        @endforeach
    </table>
    <button type="submit" class=" btn  btn-sm btn-outline-danger float-left mr-1 " id="delete-selected-rows" style="display: none"><i class="la la-trash"></i>  Delete Selected Rows</button>

</form>

    <div class="m-auto float-right">
        {{ $logs->links() }}
    </div>

    <script>
        var input = document.getElementById('myInput');
        var table = document.getElementById('myTable');
    
        input.addEventListener('keyup', function() {
            var filter = input.value.trim().toUpperCase(); // Trim and convert to uppercase
            var rows = table.getElementsByTagName('tr');
    
            for (var i = 1; i < rows.length; i++) {
                var data = rows[i].getElementsByTagName('td')[2];
    
                if (data) {
                    var textValue = data.textContent || data.innerText;
                    if (textValue.trim().toUpperCase().indexOf(filter) > -1) { // Trim and convert to uppercase
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        });
    </script>
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            const deleteButton = document.getElementById('delete-selected-rows');
            const selectAllCheckbox = document.getElementById('select-all');
    
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButtonVisibility);
            });
    
            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach((checkbox) => {
                    if (!checkbox.disabled) {
                        checkbox.checked = selectAllCheckbox.checked;
                    }
                });
                updateDeleteButtonVisibility();
            });
            // Function to update the visibility of the "Delete Selected Rows" button
            function updateDeleteButtonVisibility() {
                const atLeastOneChecked = [...checkboxes].some(checkbox => checkbox.checked);
                deleteButton.style.display = atLeastOneChecked ? 'block' : 'none';
            }
            // Call the function to set the initial state
            updateDeleteButtonVisibility();
        });
    </script>



@endsection
