@extends('layouts.app')

@section('content')
    <div class="wrapper" id="app">
        @include('dashboard.includes.nav')
        @include('dashboard.includes.aside')
        <div class="content-wrapper" >

           @yield('sub_content')
        </div>
        <loader></loader>
        <footer class="main-footer">
            <strong>Copyright © 2014-2021 <a href="http://nwslab.com" target="_blank">NWS LAB</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

@endsection

@push('js')

    <script src="/components/loader.js"></script>
@endpush
