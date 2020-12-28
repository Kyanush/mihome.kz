<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Mail;
use Mobile_Detect;
use App\Models\OrderStatusHistory;

class Order extends Model
{

    protected $table = 'orders';
    protected $fillable = [
        'type_id',
        'user_id',
        'status_id',
        'carrier_id',
        'comment',
        'delivery_date',
        'total',
        'payment_id',
        'paid',
        'payment_date',
        'payment_result',
        'where_ordered',
        'city',
        'address',
        'user_name',
        'user_phone',
        'user_email',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function($order) {

            if(env('APP_TEST') == 0)
            {
                if($order->status_id != self::find($order->id)->status_id && $order->status->notification != 0)
                {
                    $user_email = $order->user_email;
                    if($user_email)
                    {
                        $subject = env('APP_NAME') . ' - ' . 'заказ №:' . $order->id . ', статус вашего заказа';
                        Mail::to($user_email)->send(new \App\Mail\StatusUpdateOrderEmail($order, $subject));
                    }
                }
            }

            if($order->status_id != self::find($order->id)->status_id)
            {
                OrderStatusHistory::create([
                    'order_id'  => $order->id,
                    'status_id' => $order->status_id,
                    'user_id'   => Auth::user()->id
                ]);
            }

        });

        //Событие до
        static::Saving(function($model) {

            //Текущее состояние - новый
            if(!$model->status_id)
                $model->status_id = 1;

            //Тип заказа
            if(!$model->type_id)
                $model->type_id = Status::ordersType()->defaultValue()->first()->id;

            if(!$model->user_id)
                $model->user_id = null;

            if($model->user_phone)
                $model->user_phone = preg_replace("/[^0-9]/", '', $model->user_phone);

        });

        //Событие после
        static::Created(function ($modal) {
        });

        //Событие до
        static::Creating(function ($modal) {

            $detect = new Mobile_Detect();
            if($detect->isMobile()){
                $where_ordered = 2;
            }elseif($detect->isTablet()){
                $where_ordered = 3;
            }else{
                $where_ordered = 1;
            }
            $modal->where_ordered = $where_ordered;

        });



        //до
        static::deleting(function($product) {
            //история статуса
            $product->statusHistory()->delete();
            //продукты
            $product->products()->detach();
        });
    }

    public function total()
    {
        return $this->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            }, 0) + ($this->carrier ? $this->carrier->price : 0);
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Status', 'type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'status_id', 'id');
    }

    public function statusHistory()
    {
        return $this->hasMany('App\Models\OrderStatusHistory')->orderBy('created_at', 'DESC');
    }

    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id', 'id');
    }


    public function payment()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot(['id', 'name', 'sku', 'price', 'quantity', 'product_stock_id']);
    }


    public function convertArr($v){
        return is_array($v) ? $v : [$v];
    }

    public function scopeFilters($query, $filter)
    {
        if(isset($filter['id']))
            $query->WhereIn('id', $this->convertArr($filter['id']));

        if(isset($filter['user_id']))
            $query->WhereIn('user_id', $this->convertArr($filter['user_id']));

        if(isset($filter['type_id']))
            $query->WhereIn('type_id', $this->convertArr($filter['type_id']));

        if(isset($filter['status_id']))
            $query->WhereIn('status_id', $this->convertArr($filter['status_id']));

        if(isset($filter['carrier_id']))
            $query->WhereIn('carrier_id', $this->convertArr($filter['carrier_id']));

        if(isset($filter['comment']))
            $query->whereLike('comment',   $filter['comment']);

        if(isset($filter['delivery_date_start']))
            $query->whereDate('delivery_date', '>=', $filter['delivery_date_start']);
        if(isset($filter['delivery_date_end']))
            $query->whereDate('delivery_date', '<=', $filter['delivery_date_end']);

        if(isset($filter['total']))
            $query->whereLike('total',   $filter['total']);

        if(isset($filter['payment_id']))
            $query->WhereIn('payment_id', $this->convertArr($filter['payment_id']));

        if(isset($filter['paid']))
            $query->WhereIn('paid', $this->convertArr($filter['paid']));


        if(isset($filter['payment_date_start']))
            $query->whereDate('payment_date', '>=', $filter['payment_date_start']);
        if(isset($filter['payment_date_end']))
            $query->whereDate('payment_date', '<=', $filter['payment_date_end']);


        if(isset($filter['created_at_start']))
            $query->whereDate('created_at', '>=', $filter['created_at_start']);
        if(isset($filter['created_at_end']))
            $query->whereDate('created_at', '<=', $filter['created_at_end']);

        if(isset($filter['user_name']))
            $query->whereLike('user_name',   $filter['user_name']);

        if(isset($filter['user_phone']))
            $query->whereLike('user_phone',   $filter['user_phone']);

        $product_name = $filter['product_name'] ?? false;
        if($product_name)
        {
            $query->whereHas('products', function($query) use ($product_name){
                $query->where(DB::raw('t_products.name'), 'like', '%' . $product_name . '%');
            });
        }

        return $query;
    }

    public function scopeNew($query){
        return $query->where('status_id', 1);
    }

    public function whereOrdered(){
        switch ($this->where_ordered) {
            case 1:
                $title = 'Компьютер';
                $class = 'fa fa-desktop';
                break;
            case 2:
                $title = 'Телефон';
                $class = 'fa fa-mobile';
                break;
            case 3:
                $title = 'Планшет';
                $class = 'fa fa-tablet';
                break;
            default:
                $title = '';
                $class = 'Не определено';
        }

        return [
            'title' => $title,
            'class' => $class
        ];
    }

    public function adminDetailUrl(){
        return env('APP_URL') . '/admin/order/' . $this->id;
    }

}
