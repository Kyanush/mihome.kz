<?php
namespace App\Services;

use App\Models\Product;
use App\Models\ProductGroup;
use App\Tools\CopyFile;

class ServiceProductClone
{

    private $product_id;
    public $data = [];

    public $clone_group               = false,
           $clone_photo               = false,
           $clone_attributes          = false,
           $clone_specific_price      = false,
           $clone_product_images      = false,
           $clone_reviews             = false,
           $clone_product_accessories = false,
           $clone_questions_answers   = false;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public function clone()
    {
        $product = Product::find($this->product_id);

        // Create clone object
        $clone = $product->replicate();

        //Группа товаров
        if(!$this->clone_group)
            $clone->group_id = ProductGroup::create()->id;

        //Save cloned product
        $clone->view_count = 0;
        $clone->push();

        if($this->data)
        {
            $this->data['url'] = '';
            $clone->fill($this->data);
            $clone->save();
        }

        //Фото товара
        if($this->clone_photo and $product->pathPhoto())
        {
            $copyFile = new CopyFile();
            $copyFile->setNewPath($clone->productFileFolder());
            $copyFile->setOldPath($product->pathPhoto());
            $photo = $copyFile->copy();

            $clone->photo = $photo;
            $clone->save();
        }

        //категория
        foreach ($product->categories as $item)
            $clone->categories()->attach([$item->id]);

        //атрибуты
        if($this->clone_attributes)
        {
            foreach ($product->attributes as $item)
                $clone->attributes()->attach([$item->pivot->attribute_id => ['value' =>  $item->pivot->value]]);
        }

        //Скидки
        if($this->clone_specific_price and $product->specificPrice)
        {
            $specificPrice = $product->specificPrice->replicate();
            $specificPrice->product_id = $clone->id;
            $specificPrice->push();
        }

        //Картинки
        if($this->clone_product_images)
        {
            $images = $product->images;
            if($images)
            {
                foreach ($images as $image)
                {
                    $productImages = $image->toArray();
                    $productImages['product_id'] = $product->id;

                    $copyFile = new CopyFile();
                    $copyFile->setNewPath($clone->productFileFolder());
                    $copyFile->setOldPath($image->imagePath());
                    $name = $copyFile->copy();

                    $productImages['name'] = $name;
                    $clone->images()->create($productImages);
                }
            }
        }

        //С этим товаром покупают
        if($this->clone_product_accessories)
        {
            foreach ($product->productAccessories as $item)
                $clone->productAccessories()->attach([$item->pivot->accessory_product_id]);
        }

        //Отзывы
        if($this->clone_reviews)
        {
            foreach($product->reviews()->get() as $item)
            {
                $data = $item->toArray();
                unset($data['id']);
                $clone->reviews()->create($data);
            }
        }

        //Вопросы-ответы
        if($this->clone_questions_answers)
        {
            foreach($product->questionsAnswers()->get() as $item)
            {
                $data = $item->toArray();
                unset($data['id']);
                $clone->questionsAnswers()->create($data);
            }
        }

        return true;
    }

}