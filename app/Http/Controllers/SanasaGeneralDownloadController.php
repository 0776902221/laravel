<?php

namespace App\Http\Controllers;

use App\Exports\SanasaGeneralExport;
use App\Models\SanasaGeneral;
use App\Models\SanasaGeneralDownload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SanasaGeneralDownloadController extends Controller
{
 public function index()
    {
return SanasaGeneralDownload::orderBy('id','desc')->get();
 }

    public function index()
    {
        $listdata=SanasaGeneralDownload::orderBy('id','desc')->get();
        $sum=SanasaGeneralDownload::sum('amount');
        $records=SanasaGeneralDownload::sum('count');
        $last_confirmed=SanasaGeneralDownload::orderBy('created_at','desc')->limit(1)->max('to_date');
        if( $last_confirmed==NULL)
        {
            $missedItems=0;
        }
        else
        {
            $missedItems=SanasaGeneral::where('status','PENDING')->where('created_at','<=',$last_confirmed)->count();
        }
        $updatedQty=NULL;
        return view('export',compact('listdata','missedItems','updatedQty','sum','records'));
    }

    public function show( $download_id)
    {
        $sanasagenerals=SanasaGeneral::where('download_id',$download_id)->get();
        return view('exportBody',compact('sanasagenerals'));
    }

    public function store(Request $request)
    {
        $newData = $request->validate([
            'from_date'=>'required|date',
            'to_date'=>'required|date',
            'count'=>'required|numeric|min:1',
            'amount'=>'required|numeric|min:0',

        ]);
        $SanasaGeneralDownload = SanasaGeneralDownload::create($newData);
        return response()->json($SanasaGeneralDownload, 201);
    }

    public function update(Request $request, SanasaGeneralDownload $sanasaGeneralDownload)
    {
        $updateData = $request->validate([
            'from_date'=>'required|date',
            'to_date'=>'required|date',
            'count'=>'required|numeric|min:1',
            'amount'=>'required|numeric|min:0',
        ]);

        $sanasaGeneralDownload->update($updateData);
        return response()->json($sanasaGeneralDownload, 200);
    }

    public function delete(Request $request,SanasaGeneralDownload $sanasaGeneralDownload)
    {
        return ['error'=>'Unable to delete. Contact system administrator'];
    }

    public function search($from_date,$to_date)
    {
        return SanasaGeneral::where('status','PENDING')->where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->get();
    }

    public function view($from_date,$to_date)
    {
        $now=date('Y-m-d H:i:s');
        if($to_date>$now){
            $to_date=$now ;
        }

        $sanasagenerals=SanasaGeneral::where('status','PENDING')->where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->get();
        $sum=SanasaGeneral::where('status','PENDING')->where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->sum('premium');
        $items=SanasaGeneral::where('status','PENDING')->where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->count();
        return view('exportBody',compact('sanasagenerals','sum','items'));
    }

    public function confirm($from_date,$to_date,Request $request,SanasaGeneral $SanasaGeneral)
    {
        $now=date('Y-m-d H:i:s');
        if($to_date>$now){
            $to_date=$now ;
        }

        $items=SanasaGeneral::where('status','PENDING')->where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->count();

        if($items) {
            $sum = SanasaGeneral::where('status', 'PENDING')->where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date)->sum('premium');
            $newData = [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'count' => $items,
                'amount' => $sum,
            ];
            $SanasaGeneralDownload = SanasaGeneralDownload::create($newData);

            $newStatus = array('status' => 'DOWNLOAD',
                'download_id' => $SanasaGeneralDownload->id,);
            $updatedQty = SanasaGeneral::where('status', 'PENDING')->where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date)->update($newStatus);
        }
        else {
            $updatedQty = 0;
        }
            $last_confirmed = SanasaGeneralDownload::orderBy('created_at', 'desc')->limit(1)->max('to_date');
            $missedItems = SanasaGeneral::where('status', 'PENDING')->where('created_at', '<=', $last_confirmed)->count();
            $listdata = SanasaGeneralDownload::orderBy('id', 'desc')->get();
        $sum=SanasaGeneralDownload::sum('amount');
        $records=SanasaGeneralDownload::sum('count');
            return view('export', compact('missedItems', 'listdata', 'updatedQty','sum','records'));

      }

  public function missed()
  {
      $last_confirmed=SanasaGeneralDownload::orderBy('created_at','desc')->limit(1)->max('to_date');
      $sanasagenerals=SanasaGeneral::where('status','PENDING')->where('created_at','<=',$last_confirmed)->get();
      $sum=SanasaGeneral::where('status','PENDING')->where('created_at','<=',$last_confirmed)->sum('premium');
      $items=SanasaGeneral::where('status','PENDING')->where('created_at','<=',$last_confirmed)->count();
      $last_confirmed=SanasaGeneralDownload::orderBy('created_at','desc')->limit(1)->max('to_date');
      $missedItems=SanasaGeneral::where('status','PENDING')->where('created_at','<=',$last_confirmed)->count();
       return view('exportBody',compact('sanasagenerals','sum','items','missedItems'));
  }



    public function createPDF( $download_id) {
      $sanasagenerals=SanasaGeneral::where('download_id',$download_id)->get();
      $pdf = \PDF::loadView('exportBody', compact('sanasagenerals'))->setPaper('a4', 'landscape');
      $filename='SanasaList'.$download_id.'.pdf';
      return $pdf->download($filename);
    }

    public function createXLS ($download_id)
    {
        $filename='SanasaList'.$download_id.'.xls';
        $sanasagenerals=SanasaGeneral::where('download_id',$download_id)->get();
        return Excel::download(new SanasaGeneralExport($download_id),$filename);
    }

    public function createCSV ($download_id)
    {
        $filename='SanasaList'.$download_id.'.csv';
        $sanasagenerals=SanasaGeneral::where('download_id',$download_id)->get();
        return Excel::download(new SanasaGeneralExport($download_id),$filename);
    }


}






