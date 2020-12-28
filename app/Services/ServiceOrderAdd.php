<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class ServiceOrderAdd
{

    public $product_id;
    public $order_id;
    public $quantity = 1;
    public $price = 0;
    public $id = 0;
    public $price0 = false;
    public $product_stock_id = null;

    public $name = '';

    public function productAdd()
    {
        $product = Product::find($this->product_id);

        if($product)
        {

            if($this->price == 0 and !$this->price0)
            {
                if($product->specificPrice)
                    $price = $product->getReducedPrice();
                else
                    $price = $product->price;
            }else{
                $price = $this->price;
            }


            $data = [
                'product_id'       => $this->product_id,
                'order_id'         => $this->order_id,
                'name'             => $this->name ? $this->name : $product->name,

                'price'            => $price,
                'quantity'         => $this->quantity,
                'product_stock_id' => $this->product_stock_id
            ];

            if($this->id)
                $orderProduct = OrderProduct::find($this->id);
            else
                $orderProduct = new OrderProduct();

            $orderProduct->fill($data);
            $orderProduct->save();

            ServiceOrder::totalOrder($this->order_id);

        }else{
            return false;
        }
    }

}
