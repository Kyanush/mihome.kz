<?php
namespace App\Services;

use App\Contracts\ProductInterface;
use App\Models\Attribute;
use App\Models\AttributeProductValue;
use App\Models\Order;
use App\Services\ServiceUploadUrl;
use File;
use App\Models\Product;
use App\Models\ProductImage;
use App\Tools\Upload;

class ServiceProduct implements ProductInterface
{


    public static function productDelete($product_id)
    {
        if(Order::whereHas('products', function ($query) use ($product_id){
            $query->where('product_id', $product_id);
        })->first())
            return [
                'message' => 'Вы не можете удалить, есть привязанные заказы!',
                'success' => false
            ];

        $product = Product::find($product_id);
        if(!$product)
            return [
                'message' => 'Товар не найден',
                'success' => false
            ];

        foreach ($product->children as $children_product)
        {
            self::productDelete($children_product->id);
        }

        //папка товара
        File::deleteDirectory($product->productFileFolder());

        //категории
        $product->categories()->detach();

        //атритуты
        $product->attributes()->detach();

        //картинки
        $product->images()->delete();

        //аксессуары
        $product->productAccessories()->detach();

        //Отзывы
        $product->reviews()->detach();

        //подписка
        $product->subscribe()->delete();

        //скидки
        $product->specificPrice()->delete();

        //товары в корзине
        $product->cartItems()->delete();

        //Сравнение товаров
        $product->featuresCompare()->delete();

        //Мои закладки
        $product->featuresWishlist()->delete();

        //Вы смотрели продукты
        $product->youWatchedProducts()->delete();

        if($product->delete())
        {
            return [
                'message' => 'Ok',
                'success' => true
            ];
        }

        return [
            'message' => 'Ошибка',
            'success' => false
        ];
    }



    //Картинки
    public static function productImagesSave(array $images, $product_id)
    {
        //id
        //value
        //is_delete 0-нет, 1-да

        if (empty($images))
            return false;

        $product = Product::find($product_id);

        foreach ($images as $key => $item)
        {
            //добавить
            if(intval($item['is_delete']) == 0)
            {
                if(is_uploaded_file($item['value'])){

                    $upload = new Upload();
                    $upload->fileName = str_slug($product->name) . '-' . ServiceDB::tableNextId('product_images');
                    //$upload->setWidth(460);
                    //$upload->setHeight(350);
                    $upload->setPath($product->productFileFolder());
                    $upload->setFile($item['value']);

                    $images_data = [
                        'product_id' => $product_id,
                        'name'       => $upload->save(),
                        'order'      => $key
                    ];
                }
                //загрузка по ссылке

                elseif(ServiceUploadUrl::validUrlImage($item['value']))
                {
                    $serviceUploadUrl = new ServiceUploadUrl();
                    $serviceUploadUrl->name = str_slug($product->name) . '-' . ServiceDB::tableNextId('product_images');
                    $serviceUploadUrl->url = $item['value'];
                    $serviceUploadUrl->path_save = $product->productFileFolder();
                    $filename = $serviceUploadUrl->copy();
                    if($filename)
                    {
                        $images_data = [
                            'product_id' => $product_id,
                            'name'       => $filename,
                            'order'      => $key
                        ];
                    }
                }else
                    $images_data = ['order' => $key];


                $attribute = ProductImage::findOrNew($item["id"]);
                $attribute->fill($images_data);
                $attribute->save();
                //удалить
            }else{
                ProductImage::destroy($item['id']);
            }
        }
        return true;
    }

    public static function productAttributesSave(int $product_id, array $attributes)
    {
        if(empty($product_id) or count($attributes) == 0)
            return false;

        $product = Product::find($product_id);
        //Атрибуты

        //удалить все атрибуты
        $product->attributes()->detach();

        foreach ($attributes as $k => $item)
        {

            $item['value'] = $item['value'] ?? '';
            $item['value'] = (array)$item['value'];

            $name = $item['name'] ?? '';

            foreach ($item['value'] as $value)
            {
                if($value == 'null' or empty($value))
                    continue;

                $product->attributes()->attach([$item['attribute_id'] => ['value' => $value, 'name' => $name]]);
            }

        }
        return true;
    }

    public static function priceMinMax($filters)
    {
        return [
            'max' => Product::filters($filters)->filtersAttributes($filters)->max('price'),
            'min' => Product::filters($filters)->filtersAttributes($filters)->min('price')
        ];
    }

    public static function productsAttributesFilters($filters, $useInFilter = true)
    {
            $attributeProductValue = AttributeProductValue::select(['attribute_id', 'value'])
                ->whereHas('product', function($query) use ($filters){
                    $query->filters($filters);
                    $query->filtersAttributes($filters);
                })
                ->whereHas('attribute', function($query) use ($useInFilter){
                    if($useInFilter)
                        $query->useInFilter();
                    else
                        $query->whereIn('type', ['multiple_select', 'dropdown']);
                })
                ->where(function ($query){
                    $query->whereNotNull('value');
                    $query->orWhere('value', '!=', "''");
                })
                ->GroupBy(['attribute_id', 'value'])
                ->get();


            return Attribute::with(['values' => function($query) use ($attributeProductValue){

                $query->where(function ($query) use ($attributeProductValue) {
                    foreach($attributeProductValue as $value)
                    {
                        $query->orwhere(function ($query) use ($value) {
                            $query->where('attribute_id', $value->attribute_id);
                            $query->where('value', $value->value);
                        });
                    }
                });

            }])
            ->whereHas('values', function ($query) use ($attributeProductValue){

                $query->where(function ($query) use ($attributeProductValue) {
                    foreach($attributeProductValue as $value)
                    {
                        $query->orwhere(function ($query) use ($value) {
                            $query->where('attribute_id', $value->attribute_id);
                            $query->where('value', $value->value);
                        });
                    }
                });
            })
            ->get();
    }

}
