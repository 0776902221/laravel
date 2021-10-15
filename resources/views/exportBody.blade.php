


<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>




<table class="table table-bordered mb-5">
    <thead>
    <tr class="table-danger">
        <th scope="col">#</th>
        <th scope="col">Issued Time</th>
        <th scope="col">Vehicle Number</th>
        <th scope="col">Vehicle Type</th>
        <th scope="col">Chassis No</th>
        <th scope="col">salutation</th>
        <th scope="col">Name</th>
        <th scope="col">Current owner</th>
        <th scope="col">NIC</th>
        <th scope="col">Mobile</th>
        <th scope="col">Address</th>
        <th scope="col">Valid From</th>
        <th scope="col">Valid To</th>
        <th scope="col">Premium</th>
        <th scope="col">Post Office</th>


    </tr>
    </thead>
    <tbody>
    @foreach($sanasagenerals as $data)
        <tr> <th scope="row">{{ $data->id }}</th>
            <td>{{$data->created_at}}</td>
            <td>{{$data->vehicle_number}}</td>
            <td>{{$data->vehicle_type}}</td>
            <td>{{$data->chassis_no}}</td>
            <td>{{$data->salutation}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->current_owner}}</td>
            <td style="text-align:left"> {{ $data->nic}}</td>
            <td style="text-align:left"> {{$data->mobile_number}}</td>
            <td>{{$data->address}}</td>
            <td>{{$data->valid_from}}</td>
            <td>{{$data->valid_to}}</td>
            <td style="text-align:right">{{number_format($data->premium, 2, '.', ',')}}</td>
            <td>{{$data->post_office}}</td>

        </tr>

    @endforeach
    </tbody>
</table>


