<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Payment;
use App\Requests\SavePaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends AdminController
{

    public function list(Request $request)
    {
        $list =  Payment::search($request->input('search'))
                        ->OrderBy('ID', 'DESC')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SavePaymentRequest $request)
    {
        $data = $request->all();
        $data = $data['payment'];

        $payment = Payment::findOrNew($data["id"]);
        $payment->fill($data);
        $payment->save();

        return  $this->sendResponse($payment ? $payment->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(Payment::findOrFail($id));
    }

    public function delete($id)
    {
        return  $this->sendResponse(Payment::destroy($id) ? true : false);
    }

}