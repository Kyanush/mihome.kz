<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 13.04.2020
 * Time: 17:42
 */

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IsStockProductEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $product, $subject;

    public function __construct(Product $product, $subject)
    {
        $this->product  = $product;
        $this->subject  = $subject;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mails.is_stock_product');
    }

}