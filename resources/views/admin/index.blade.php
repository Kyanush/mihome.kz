@extends('layouts.admin')
@section('content')

    <? $user = \App\User::with('role')->find(Auth::user()->id); ?>
    <div id="app">
        <layout :user="{{ $user }}"></layout>
    </div>


    <?php
    $permission_ids = Auth::user()->permissions()->pluck('name')->toArray();
    ?>
    <script>
        window.permissions = {!! json_encode($permission_ids, true) !!};
        window.user        = {!! json_encode([
                                                'name'  => $user->name,
                                                'email' => $user->email,
                                             ], true)       !!};
    </script>

@endsection
