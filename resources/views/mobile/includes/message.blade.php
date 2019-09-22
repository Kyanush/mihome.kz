@if(isset($errors))
    @if (count($errors) > 0)
        <div class="message">
            <div class="warning _red">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif
@endif

@if(session()->has('attention'))
    <div class="message">
        <div class="warning _blue">
            {{ session()->get('attention') }}
        </div>
    </div>
@endif

@if(session()->has('success'))
    <div class="message">
        <div class="warning _green">
            {{ session()->get('success') }}
        </div>
    </div>
@endif