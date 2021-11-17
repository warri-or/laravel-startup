<?php

namespace App\Http\Modules\Pdf;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class PdfController extends Controller
{
    public $pdfService;
    public function __construct(PdfService $service){
        $this->pdfService = $service;
    }
    public function downloadPdf(){
        $data['title'] = 'Sujoy';
        $pdf = $this->pdfService->create_pdf('product',$data);
        return $pdf->download('invoice.pdf');
    }

    public function viewPdf(){
//        $pdf = $this->pdfService->create_pdf('product');
//        return $pdf->stream();
        return view('pdf.product');
    }
}
