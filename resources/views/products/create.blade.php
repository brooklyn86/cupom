@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <form method="post" action="{{route('create.product')}}">
        @csrf
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Cadastro de Produtos</h3>
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Cadastrar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nome do produto</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Valor do produto</label>
                            <input class="form-control" type="text" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Detalhe do produto</label>
                            <textarea class="form-control"  id="description" name="description" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush