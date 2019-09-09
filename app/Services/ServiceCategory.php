<?php
namespace App\Services;

use App\Models\Category;
use App\Models\CategoryFilterLink;
use App\Tools\Helpers;

class ServiceCategory
{


    public static function catalogsTree($type = 1)
    {
        $list = Category::OrderBy('sort')->get();
        $data = $list->map(function ($item) use ($type) {

            if($type == 1)
            {
                return[
                    'id'        => $item->id,
                    'active'    => $item->active,
                    'url'       => $item->url,
                    'text'      => $item->name,
                    'parent_id' => $item->parent_id,
                    'icon'      => 'fa fa-folder icon-state-default',
                    'opened'    => false
                ];
            }else if($type == 2){
                return [
                    'id'        => $item->id,
                    'active'    => $item->active,
                    'name'      => $item->name,
                    'parent_id' => $item->parent_id,
                ];
            }
        });

        return Helpers::createTree($data);
    }

    //все дочерние ид
    public static function categoryChildIds($parent_id, $self_id_add = true, $active = null)
    {
        $categories_ids = [];

        if($self_id_add)
            $categories_ids[] = $parent_id;

        $category = Category::OrderBy('sort')->where(function ($query) use ($active){
            if($active === true)
                $query->isActive();
            if($active === false)
                $query->isNotActive();
        })->where('parent_id', $parent_id)->get();

        foreach ($category as $item)
        {
            $categories_ids[] = $item['id'];
            $childCategories = self::categoryChildIds($item['id'], false, $active);
            if(count($childCategories) > 0)
            {
                $categories_ids = array_merge($categories_ids, $childCategories);
            }
        }
        return $categories_ids;
    }


    public static function getParents($parent_id){
        $data = [];
        $category = Category::find($parent_id);
        $data[] = $category;
        if($category->parent_id){
            $data = array_merge($data, self::getParents($category->parent_id));
        }
        return $data;
    }

    public static function breadcrumbCategories($category_id, $current_title, $current_link = ''){
        $breadcrumb[] = [
            'title' => 'Главная',
            'link'  => '/'
        ];

        if($category_id)
        {
            $categories = self::getParents($category_id);
            foreach (array_reverse($categories) as $category)
            {
                $breadcrumb[] = [
                    'title' => $category->name,
                    'link'  => $category->catalogUrl()
                ];
            }
        }

        $breadcrumb[] = [
            'title' => $current_title,
            'link'  => $current_link
        ];

        return $breadcrumb;
    }

}