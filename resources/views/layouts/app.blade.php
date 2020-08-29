<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth
        
        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/js/jquery.mask.js"></script>
        <script src="/js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        @if(session()->has('success'))
            <script>
                swal("Good job!", "{{session('success')}}", "success");
            </script>
        @elseif(session()->has('error'))
            <script>
                swal("Good job!", "{{session('error')}}", "error");
            </script>
        @endif
        <script>
                $('#sendmail').on('show.bs.modal', function (event) {
                    var modal = $(this);
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    modal.find('#id').val(id);
                });
                
            $(document).ready(function(){
                $('#price').mask('000.000.000.000.000,00', {reverse: true});
                $('.form-control .price').mask('000.000.000.000.000,00', {reverse: true});
                $('#cpf').mask('000.000.000-00', {reverse: true});
                $('#productList').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '/returnProductList',
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'nome', name: 'nome' },
                        { data: 'description', name: 'description' },
                        { data: 'price', name: 'price' },
                        { data: 'actions', name: 'actions' },
                    ]
                });

                $('#notasList').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '/returnNotaList',
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'cliente', name: 'cliente' },
                        { data: 'cpf', name: 'cpf' },
                        { data: 'price', name: 'price' },
                        { data: 'date', name: 'date' },
                        { data: 'actions', name: 'actions' }

                    ]
                });
            });
            $('#name-autocomplete').autocomplete({
                deferRequestBy: 600,
                serviceUrl: '/autocomplete/product',
                noCache: true,
                onSearchStart: function () {
                    $('#searchLoadingFilterUser').css('display', 'block');
                },
                onSearchComplete: function (query, suggestions) {
                    $('#searchLoadingFilterUser').css('display', 'none');
                },
                onSelect: function (suggestion) {
                    $("#name-autocomplete").val(suggestion.value)
                    $("#product_id").val(suggestion.dados.id)
                    $("#price").val(suggestion.dados.price)
                },
                showNoSuggestionNotice: true,
                noSuggestionNotice: "Nenhum produto encontrado!",
                minChars: 3
            });
        </script>
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
        <script>
        function Task(data) {
            this.id = ko.observable(data.id);
            this.title = ko.observable(data.title);
            this.price = ko.observable(data.price);
            this.info = ko.observable(data.info);
            this.quantidade = ko.observable(data.quantidade);
            this.isDone = ko.observable(data.isDone);
        }

        function TaskListViewModel() {
            // Data
            var self = this;
            self.tasks = ko.observableArray([]);
            self.newTaskId = ko.observable("");
            self.newTaskText = ko.observable("");
            self.newTaskPrice = ko.observable("");
            self.newTaskInfo = ko.observable("");
            self.newTaskQuantidade = ko.observable(1);
            self.incompleteTasks = ko.computed(function() {
                return ko.utils.arrayFilter(self.tasks(), function(task) { return !task.isDone() });
            });

            // Operations
            self.addTask = function() {
                self.tasks.push(new Task({id : $("#product_id").val(), title: $("#name-autocomplete").val(), price :  $("#price").val(), info : this.newTaskInfo(), quantidade : this.newTaskQuantidade()}));
                self.newTaskId("");
                self.newTaskText("");
                self.newTaskPrice("");
                self.newTaskInfo("");
                self.newTaskQuantidade("");
            };
            self.removeTask = function(task) { self.tasks.remove(task) };
        }

        ko.applyBindings(new TaskListViewModel());
        </script>
    </body>
</html>