<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 13.04.2020
 * Time: 17:42
 */

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $order, $subject;

    public function __construct(Order $order, $subject)
    {
        $this->order    = $order;
        $this->subject  = $subject;
    }

    public function build()
    {

        return $this->subject($this->subject)
                    ->view('mails.order');
    }

}