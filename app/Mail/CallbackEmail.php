<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 13.04.2020
 * Time: 17:42
 */

namespace App\Mail;

use App\Models\Callback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallbackEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $data, $subject;

    public function __construct(Callback $data, $subject)
    {
        $this->data     = $data;
        $this->subject  = $subject;
    }

    public function build()
    {

        return $this->subject($this->subject)
                    ->view('mails.callback');
    }

}