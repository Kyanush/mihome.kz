<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{

    public function listPayments()
    {
        $payments = Payment::OrderBy('id')->get();

        $data = $payments->map(function ($item) {
            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'logo'          => $item->pathLogo(true)
            ];
        });

        return  $this->sendResponse($data);
    }

}