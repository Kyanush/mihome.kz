<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <!--<h3 class="breadcrumb-header"> СМАРТ ЧАСЫ AMAZFIT STRATOS SPORT BLACK</h3>--->
                <ul class="breadcrumb-tree">
                    @foreach($breadcrumbs as $key => $item)
                        @if(!empty($item['link']))
                            <li>
                                <a href="{{ $item['link'] }}">
                                    <span>{{ $item['title'] }}</span>
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