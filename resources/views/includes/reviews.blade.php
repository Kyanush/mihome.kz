
   <!-- commentbook -->
   <script src="{{ asset('/commentbook/script.js') }}" data-jv-id="d5ShOZJS9K"></script>
   <!-- commentbook -->


@php
   $data_id    = $product->parent_id ? $product->parent->comment_id : $product->comment_id;
   if(!$data_id)
   {
        $data_id = $product->parent_id ? $product->parent_id : $product->id;
   }

   $data_title = $product->parent_id ? $product->parent->name       : $product->name;
@endphp

<div type="lis-comments"
     lis-widget="reviews"
     data-id="{{ $data_id }}"
     data-title="{{ $data_title }}">
</div>

