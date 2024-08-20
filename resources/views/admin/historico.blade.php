@extends('layouts.layout')

@section('title', 'Histórico')

@section('content')
    {{-- <h1 class="app-page-title">Histórico</h1> --}}

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-12">

            <div class="row">

                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Mensagens</h4>
                            <div class="stats-figure">{{ isset($mensagens) ? count($mensagens) : 0 }}</div>
                            <div class="stats-meta text-success">
                                <i class="fas fa-calculator"></i> Total
                            </div>
                        </div>
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                </div>
                
                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Mensagens</h4>
                            <div class="stats-figure">{{ isset($mensagensPendentes) ? count($mensagensPendentes) : 0 }}</div>
                            <div class="stats-meta text-danger">
                                <i class="fas fa-clock"></i> Pendentes
                            </div>
                        </div>
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Mensagens</h4>
                            <div class="stats-figure">{{ isset($mensagensEnviadas) ? count($mensagensEnviadas) : 0 }}</div>
                            <div class="stats-meta text-success">
                                <i class="fas fa-arrow-up"></i> Enviadas
                            </div>
                            </div>
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                </div>
                
                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Mensagens</h4>
                            <div class="stats-figure">{{ isset($messagensError) ? count($messagensError) : 0 }}</div>
                            <div class="stats-meta text-danger">
                                <i class="fas fa-times"></i> Erros
                            </div>
                        </div>
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-12 col-lg-12">

            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 table-responsive" id="table" style="width: 100%">
                        <thead>
                        <tr>
                            <th scope="col">Destino</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Mensagem</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Enviado em</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    <script>

        let table = new DataTable('#table', {
            responsive: true,
            ajax: '/historico/datatables',
            lengthChange: true,
            autoFill: true,
            select: {
                style: 'multi'
            },
            processing: false,
            deferRender: true,
            cache: true,
            destroy: true,
            serverSide: false,
            stateSave: true,
            searchDelay: 350,
            search: {
                "smart": true,
                "caseInsensitive": false
            },
            columns: [
                { data: 'contato.number', name: 'contato.number' },
                { data: 'tag.name', name: 'tag.name' },
                { data: 'template.name', name: 'template.name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'send_at', name: 'send_at' },
                { data: 'status', name: 'status' },
            ],
            columnDefs: [
                {
                    targets: 3,
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YY HH:mm');
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        return data ? moment(data).format('DD/MM/YY HH:mm') : '';
                    }
                },
                {
                    targets: 5,
                    render: function (data, type, row) {
                        return data == 'pending' ? '<span class="badge bg-warning">Pendente</span>' : data == 'sent' ? '<span class="badge bg-success">Enviado</span>' : '<span class="badge bg-danger">Erro</span>';
                    }
                }
            ]
        });

    </script>

    @endsection
    
@endsection