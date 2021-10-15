<?php
namespace App\Exports;

use App\Models\SanasaGeneral;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SanasaGeneralExport implements FromView
{
protected $id;
private $download_id;

function __construct($id){
        $this->download_id=$id;
}

public function view(): View
{
    $sanasagenerals=SanasaGeneral::where('download_id', $this->download_id)->get();
    return view('exportBody', ['sanasagenerals'=>$sanasagenerals]);
}


}








