<?php

namespace App\Http\Modules\Pdf;

class PdfService
{
    // Your methods for repository

    public function create_pdf($template,$data=[]){
        return PDF::loadView('pdf.'.$template, $data);
    }
}
