@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <style>
    .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
    .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
    .autocomplete-selected { background: #F0F0F0; }
    .autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
    .autocomplete-group { padding: 2px 5px; }
    .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
    </style>
    <div class="container-fluid mt--7" id="list">
        <form method="post" action="{{route('create.nota.post')}}">
        @csrf
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Criação de nota não fiscal</h3>
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Criar Nota</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nome do Cliente</label>
                            <input class="form-control" type="text" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">CPF</label>
                            <input class="form-control" type="text" id="cpf" name="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Endereço</label>
                            <input class="form-control" type="text" id="endereco" name="endereco" required>
                        </div>
                        <filedset>
                            <legend>Produtos Comprados</legend>
                            <div class="form-group">
                                <input type="hidden" id="product_id" data-bind="value : newTaskId, change: newTaskId" />
                                <label for="example-text-input" class="form-control-label">Nome do produto</label>
                                <input class="form-control" type="text" id="name-autocomplete" data-bind="value : newTaskText, change : newTaskText">
                                <div class="autocomplete-suggestions">
                                    <div class="autocomplete-suggestion" id="searchLoadingFilterUser"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Valor do produto</label>
                                <input class="form-control" id="price" type="text" data-bind="value: newTaskPrice,change: newTaskPrice">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Quantidade</label>
                                <input class="form-control" type="number" data-bind="value: newTaskQuantidade">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Informações adicionais</label>
                                <input class="form-control" type="text" data-bind="value: newTaskInfo">
                            </div>
                            <textarea class="form-control invisible" name="json" data-bind="value: ko.toJSON(tasks)" required></textarea>
                            
                        <filedset>
                        <button class="btn btn-sm btn-success"  data-bind="click: addTask">Adicionar Produto</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-xl-12 mb-5 mb-xl-0" data-bind="visible: tasks().length > 0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Produtos</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Concluido</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Detalhes</th>
                            <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: tasks">
                            <tr>
                                <td><input class="form-control" type="checkbox" data-bind="checked: isDone" /> </td>
                                <td><input class="form-control" data-bind="value: id, disable: isDone" /> </td>
                                <td><input class="form-control" data-bind="value: title, disable: isDone" /> </td>
                                <td><input class="form-control price" data-bind="value: price, disable: isDone" /> </td>
                                <td><input class="form-control" type="number" data-bind="value: quantidade, disable: isDone" /></td>
                                <td> <input class="form-control" data-bind="value: info, disable: isDone" /></td>
                                <td><a class="btn btn-danger" href="#" data-bind="click: $parent.removeTask">Remover da lista</a></td>
                            </tr>
                        </tbody>
                        </table>

                </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
