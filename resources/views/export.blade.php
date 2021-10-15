//composer require maatwebsite/excel
//php artisan make:export SanasaGeneralExport --model=SanasaGeneral


<html>
<head>
    <title>

    </title>
</head>
<body>



    <style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<script>
    function search()
    {
    const fromDate=document.getElementById("from_date").value;
    const fromTime=document.getElementById("from_time").value;
    const toDate=document.getElementById("to_date").value;
    const toTime=document.getElementById("to_time").value;
    const newUrl='view/'+fromDate+' '+fromTime +'/'+toDate+' '+toTime;
    window.open(newUrl,'tab');
    }

    function confirm()
    {
        const fromDate=document.getElementById("from_date").value;
        const fromTime=document.getElementById("from_time").value;
        const toDate=document.getElementById("to_date").value;
        const toTime=document.getElementById("to_time").value;
        const newUrl='confirm/'+fromDate+' '+fromTime +'/'+toDate+' '+toTime;
        window.open(newUrl);
    }

    function missedDetails()
    {
        const newUrl='missed/';
        window.open(newUrl,'tab');
    }

</script>



    <?php
    $today=date('Y-m-d');
    $time=date('H:i:s');
    $yesterday=date('Y-m-d',strtotime("-1 days"));
    ?>


<form  method="get" action="#" >
    @csrf
    <div>
        <label><h1 style="text-align: center">Sanasa General Insurance</h1></label>
        <label><h3 style="text-align: center">Confirm the records </h3></label>
    </div>

    <hr>

    <div style="display: flex" class="my-2" >
    <label for="from_date"><h4>Search From : </h4></label>
    <input type="date" id="from_date" value="2021-05-01" />
    <input type="time" id="from_time" value="15:00:01" />
    </div>

    <div style="display: flex" class="my-2" >
    <label for="to_date"><h4>Search Upto :</h4> </label>
    <input type="date" id="to_date" value="{{$yesterday}}" />
    <input type="time" id="to_time" value="15:00:00" />
    </div>

    <div style="display: flex" class="my-2" >
    <button class="btn btn-primary" onclick="search();" value="Search">Search</button>
    <button class="btn btn-primary" onclick="confirm();" value="Confirmed">Confirm</button>
@if($missedItems)
    <button class="btn btn-alert" onclick="missedDetails();" >You have missed Items</button>
@endif
    </div>
</form>

    <hr>
    <h3>Recent confirmations</h3>
<table class="table table-bordered mb-5">
    <thead>
    <tr class="table-danger">
        <th scope="col">#</th>
        <th scope="col">Confirmed at</th>
        <th scope="col">From date</th>
        <th scope="col">To date</th>
        <th scope="col">Count</th>
        <th scope="col">Amount</th>
        <th scope="col"> Action </th>
        <th scope="col">Download </th>
    </tr>
    </thead>
    <tbody>

    @foreach($listdata as $data)
        <tr> <th scope="row"> {{ $data->id }} </th>
            <td> {{$data->created_at}} </td>
            <td> {{$data->from_date}} </td>
            <td> {{$data->to_date}} </td>
            <td style="text-align:right"> {{$data->count}} </td>
            <td style="text-align:right"> {{number_format($data->amount, 2)}} </td>
            <td><a target="_blank" href="http://127.0.0.1:8000/api/SanasaGenerals/download/{{ $data->id }}"> View </a></td>
            <td><a href="http://127.0.0.1:8000/api/SanasaGenerals/xls/{{ $data->id }}"> Excel</a> |
               <a href="http://127.0.0.1:8000/api/SanasaGenerals/pdf/{{ $data->id }}"> PDF</a> |
                <a href="http://127.0.0.1:8000/api/SanasaGenerals/csv/{{ $data->id }}"> CSV </a>
            </td>
        </tr>

    @endforeach
    </tbody>
</table>

    <h4>You have confirmed {{number_format($records, 0)}} records of insurance premiums worth Rs  {{number_format($sum, 2)}} </h4>


</body>
</html>
