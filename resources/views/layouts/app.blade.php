<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NWS LAB</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="stylesheet" href="/plugins/toastr/toastr.css">
    @stack('css')
     <style>
         /* Absolute Center Spinner */
         .loading {
             position: fixed;
             z-index: 999;
             height: 2em;
             width: 2em;
             overflow: show;
             margin: auto;
             top: 0;
             left: 0;
             bottom: 0;
             right: 0;
         }

         /* Transparent Overlay */
         .loading:before {
             content: '';
             display: block;
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

             background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
         }

         /* :not(:required) hides these rules from IE9 and below */
         .loading:not(:required) {
             /* hide "loading..." text */
             font: 0/0 a;
             color: transparent;
             text-shadow: none;
             background-color: transparent;
             border: 0;
         }

         .loading:not(:required):after {
             content: '';
             display: block;
             font-size: 10px;
             width: 1em;
             height: 1em;
             margin-top: -0.5em;
             -webkit-animation: spinner 150ms infinite linear;
             -moz-animation: spinner 150ms infinite linear;
             -ms-animation: spinner 150ms infinite linear;
             -o-animation: spinner 150ms infinite linear;
             animation: spinner 150ms infinite linear;
             border-radius: 0.5em;
             -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
             box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
         }

         /* Animation */

         @-webkit-keyframes spinner {
             0% {
                 -webkit-transform: rotate(0deg);
                 -moz-transform: rotate(0deg);
                 -ms-transform: rotate(0deg);
                 -o-transform: rotate(0deg);
                 transform: rotate(0deg);
             }
             100% {
                 -webkit-transform: rotate(360deg);
                 -moz-transform: rotate(360deg);
                 -ms-transform: rotate(360deg);
                 -o-transform: rotate(360deg);
                 transform: rotate(360deg);
             }
         }
         @-moz-keyframes spinner {
             0% {
                 -webkit-transform: rotate(0deg);
                 -moz-transform: rotate(0deg);
                 -ms-transform: rotate(0deg);
                 -o-transform: rotate(0deg);
                 transform: rotate(0deg);
             }
             100% {
                 -webkit-transform: rotate(360deg);
                 -moz-transform: rotate(360deg);
                 -ms-transform: rotate(360deg);
                 -o-transform: rotate(360deg);
                 transform: rotate(360deg);
             }
         }
         @-o-keyframes spinner {
             0% {
                 -webkit-transform: rotate(0deg);
                 -moz-transform: rotate(0deg);
                 -ms-transform: rotate(0deg);
                 -o-transform: rotate(0deg);
                 transform: rotate(0deg);
             }
             100% {
                 -webkit-transform: rotate(360deg);
                 -moz-transform: rotate(360deg);
                 -ms-transform: rotate(360deg);
                 -o-transform: rotate(360deg);
                 transform: rotate(360deg);
             }
         }
         @keyframes spinner {
             0% {
                 -webkit-transform: rotate(0deg);
                 -moz-transform: rotate(0deg);
                 -ms-transform: rotate(0deg);
                 -o-transform: rotate(0deg);
                 transform: rotate(0deg);
             }
             100% {
                 -webkit-transform: rotate(360deg);
                 -moz-transform: rotate(360deg);
                 -ms-transform: rotate(360deg);
                 -o-transform: rotate(360deg);
                 transform: rotate(360deg);
             }
         }
     </style>
</head>
<body class="{{request()->is('login*')|| request()->is('user-invitation*')  ?'hold-transition login-page':'sidebar-mini'}}">
@yield('content')

<!-- /.login-box -->
<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<script src="/plugins/vue/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@<3.0.0/dist/vee-validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>

@stack('js')

<script>


    // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    @foreach (['success', 'warning', 'error', 'info'] as $key)
            @if ($value = session($key))

              toastr.{{$key}}('{{session()->get($key)}}');


            @endif
     @endforeach


    window.VeeValidate = VeeValidate;

    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


    // Add a request interceptor
    axios.interceptors.request.use(function (config) {
        $(document).trigger('loader.update',true);
        return config;
    }, function (error) {
        $(document).trigger('loader.update',false);
        return Promise.reject(error);
    });

    // Add a response interceptor
    axios.interceptors.response.use(function (response) {

        $(document).trigger('loader.update',false);

        return response;
    }, function (error) {
        $(document).trigger('loader.update',false);

        return Promise.reject(error);
    });



    Vue.prototype.$http = axios

    Vue.use(VeeValidate, {
        events: 'input|change|blur',
    });


    Vue.prototype.$setErrorsFromResponse = function (errorResponse) {
        // only allow this function to be run if the validator exists
        if (!this.hasOwnProperty('$validator')) {
            return;
        }

        // clear errors
        this.$validator.errors.clear();

        // check if errors exist
        if (!errorResponse.hasOwnProperty('errors')) {
            return;
        }

        let errorFields = Object.keys(errorResponse.errors);

        // insert laravel errors

        errorFields.map(field => {
            this.$validator.errors.add({
                field: field,
                msg: errorResponse.errors[field][0]
            });
        });

    };


    var app = new Vue({
        el: "#app",
        methods: {}
    });

</script>

</body>
</html>
