<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanasaGeneral;
use App\Rules\NIC;
use App\Rules\VehicleNumber;
use App\Rules\Phone;
use Illuminate\Validation\Rule;
use App\Exports\SanasaGeneralExport;
use Maatwebsite\Excel\Facades\Excel;

class SanasaGeneralController extends Controller
{

    public function index()
    {
       return SanasaGeneral::all();
    }

    public function create()
    {
       return view('api/sanasageneralnew');
    }

    public function show(SanasaGeneral $SanasaGeneral)
    {
        return $SanasaGeneral;
    }

    public function store(Request $request)
    {
        $newData = $request->validate([
            'slpost_ref'=>'required',
            'vehicle_number'=>['required',new VehicleNumber],
            'vehicle_type'=>'required',
            'chassis_no'=>'required',
            'salutation'=>'required',
            'name'=>'required',
            'current_owner'=>'required',
            'nic'=>['required',new NIC],
            'mobile_number'=>['required',new Phone],
            'address'=>'required',
            'valid_from'=>'required|date',
            'valid_to'=>'required|date|after:valid_from',
            'premium'=>'required|numeric|min:0.01',
            'status'=>['required',Rule::in(['Pending','Download','Cancelled'])],            'post_office'=>'required',
        ]);
        $SanasaGeneral = SanasaGeneral::create($newData);
        return response()->json($SanasaGeneral, 201);
    }

    public function update(Request $request, SanasaGeneral $SanasaGeneral)
    {
        $updateData = $request->validate([
            'slpost_ref'=>'required',
            'vehicle_number'=>['required',new VehicleNumber],
            'vehicle_type'=>'required',
            'chassis_no'=>'required',
            'salutation'=>'required',
            'name'=>'required',
            'current_owner'=>'required',
            'nic'=>['required',new NIC],
            'mobile_number'=>['required',new Phone],
            'address'=>'required',
            'valid_from'=>'required|date',
            'valid_to'=>'required|date|after:valid_from',
            'premium'=>'required|numeric|min:0.01',
            'status'=>['required',Rule::in(['Pending','Download','Cancelled'])],
        ]);

        $SanasaGeneral->update($updateData);
        return response()->json($SanasaGeneral, 200);
    }

     public function delete(Request $request,SanasaGeneral $SanasaGeneral)
    {
       //$SanasaGeneral->delete();
       //return response()->json(null, 204);

       if($SanasaGeneral['status']=='PENDING')
        	{
         	$request['status']='Cancelled';
          	$SanasaGeneral->update($request->all());
         	return response()->json($SanasaGeneral, 200);
         	}
       elseif($SanasaGeneral['status']=='DOWNLOAD')
        	{
        	return ['error'=>'Already Paid to Company'];
        	}
       elseif($SanasaGeneral['status']=='CANCELLED') 
        	{
        	return ['error'=>'Already deleted'];
        	}
       else
        	{
        	return ['error'=>'Unable to delete. Contact system administrator'];
        	}

    }



public function download(Request $request,$from_date,$to_date)
    {
   
       return SanasaGeneral::where('status','PENDING')->where('created_at','>',$from_date)->where('created_at','<',$to_date)->get();
    }

public function export() 
    {

       return Excel::download(new SanasaGeneralExport, 'users.CSV');
    }






}
