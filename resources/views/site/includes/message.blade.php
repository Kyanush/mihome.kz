@if(count($errors) > 0 or session()->has('attention') or session()->has('success'))
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            @if(isset($errors))
                @if (count($errors) > 0)
                   <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                   </div>
                @endif
            @endif
            @if(session()->has('attention'))
                <div class="alert alert-warning">
                    {{ session()->get('attention') }}
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
@endif
