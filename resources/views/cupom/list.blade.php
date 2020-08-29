@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Listagem de notas</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('create.nota')}}" class="btn btn-sm btn-primary">Criar nova nota</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center" id="notasList">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">Codigo</th>
                                        <th scope="col" class="sort" data-sort="budget">Nome do Cliente</th>
                                        <th scope="col" class="sort" data-sort="budget">CPF</th>
                                        <th scope="col" class="sort" data-sort="status">Valor</th>
                                        <th scope="col" class="sort" data-sort="status">Data da compra</th>
                                        <th scope="col" class="sort" data-sort="status"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="sendmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Envio de e-mail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <form action="{{route('sendmail')}}">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" />
                            <input class="form-control" type="hidden" name="id" id="id" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
