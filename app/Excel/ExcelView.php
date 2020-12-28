<?php
namespace App\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelView implements FromView
{
    public $data;
    public $blade;

    public function __construct($data, $blade)
    {
        $this->data  = $data;
        $this->blade = $blade;
    }

    public function view(): View
    {
        return view($this->blade, $this->data);
    }

}
