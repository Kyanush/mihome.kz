<?php
namespace App\Services;

use Mpdf\Mpdf;

class ServicePrint
{

    public $format;
    public $title;
    public $result;

    public function print(){
        if($this->format == 'excel')
        {

            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename={$this->title}.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            return $this->result;
        }else{
            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($this->result);
            $mpdf->Output();
        }
    }

}