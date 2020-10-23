<nav class="navbar navbar-default">
    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav navbar-nav">


            @php
                $categories_id_more = [];
                $categories = \App\Models\Category::orderBy('sort', 'desc')->limit(5)->where('parent_id', 324)->get();
            @endphp


            @foreach($categories as $category)
                @php
                    $categories_id_more[] = $category->id;
                @endphp
                <li class="dropdown mega-dropdown">
                    <a href="{{ $category->catalogUrl() }}" data-toggle="" class="dropdown-toggle">
                        {{ $category->name }}
                    </a>
                    @php
                        $categories2 = $category->children()->orderBy('sort', 'desc')->get();
                    @endphp
                    @if(count($categories2) > 0)
                        <ul class="dropdown-menu mega-dropdown-menu row">
                            <li class="divider"></li>
                            @if($category->id == 3)
                                @foreach($categories2 as $category2)
                                    <li class="col-sm-4">
                                        <ul>
                                            <li class="dropdown-header">
                                                <a href="{{ $category2->catalogUrl() }}">
                                                    {{ $category2->name_short ? $category2->name_short : $category2->name }}
                                                </a>
                                            </li>
                                            
                                            @php
                                                $products = \App\Models\Product::main()
                                                                        ->orderByRaw('FIELD(status_id, 10, 11, 12), sort desc')
                                                                        ->filters(['category_id' => $category2->id])
                                                                        ->get();
                                            @endphp

                                            @foreach($products as $product)
                                                <li>
                                                    <a href="{{ $product->detailUrlProduct() }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @else
                                    <li class="col-sm-4">
                                        <ul>
                                            @foreach($categories2 as $category2)
                                            <li>
                                                <a href="{{ $category2->catalogUrl() }}">
                                                    {{ $category2->name_short ? $category2->name_short : $category2->name }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                            @endif
                        </ul>
                    @endif
                </li>
            @endforeach





            <li class="dropdown mega-dropdown">
                <a data-toggle="" class="dropdown-toggle">
                    <b>Еще</b>
                </a>
                <ul class="dropdown-menu mega-dropdown-menu row">

                    <li class="divider"></li>

                    @php
                        $categories = \App\Models\Category::whereNotIn('id', $categories_id_more)->orderBy('sort', 'desc')->where('parent_id', 324)->get();
                    @endphp

                    @foreach($categories as $category)
                        <li class="col-sm-4">
                            <ul>
                                <li>
                                    <a href="{{ $category->catalogUrl() }}">
                                        <b>{{ $category->name_short ? $category->name_short : $category->name }}</b>
                                    </a>
                                </li>
                                @php
                                    $categories2 = $category->children()->orderBy('sort', 'desc')->get();
                                @endphp
                                @foreach($categories2 as $category2)
                                    <li>
                                        <a href="{{ $category2->catalogUrl() }}">
                                            {{ $category2->name_short ? $category2->name_short : $category2->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach


                </ul>
            </li>





        </ul>
    </div>
</nav>