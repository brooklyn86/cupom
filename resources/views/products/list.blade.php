@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Lista de Produtos</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('product.create')}}" class="btn btn-sm btn-primary">Cadastrar novo produto</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center" id="productList">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">ID</th>
                                        <th scope="col" class="sort" data-sort="budget">Nome</th>
                                        <th scope="col" class="sort" data-sort="status">Descrição</th>
                                        <th scope="col" class="sort" data-sort="status">Preço</th>
                                        <th scope="col" class="sort" data-sort="status">Ação</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush