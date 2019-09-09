<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <!--<h3 class="breadcrumb-header"> СМАРТ ЧАСЫ AMAZFIT STRATOS SPORT BLACK</h3>--->
                <ul class="breadcrumb-tree" itemscope itemtype="http://schema.org/BreadcrumbList">
                    @foreach($breadcrumbs as $key => $item)
                        @if(!empty($item['link']))
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="{{ $item['link'] }}">
                                    <span itemprop="name">{{ $item['title'] }}</span>
                                    <meta itemprop="position" content="{{ $key + 1 }}"/>
                                </a>
                            </li>
                        @else
                            <li class="active">
                               {{ $item['title'] }}
                            </li>
                        @endif
                    @endforeach
                </ul>

            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

@include('schemas.breadcrumb_list', ['breadcrumbs' => $breadcrumbs])

@include('site.includes.message')