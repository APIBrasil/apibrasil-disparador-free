@extends('layouts.layout')

@section('title', 'Histórico')

@section('content')
    <h1 class="app-page-title">Histórico</h1>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive table-responsive-large" id="table">
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
                        <tbody>

                        @foreach ($mensagens as $item)
                        <tr>
                            <th scope="row">
                                {{ $item->contato ? $item->contato->number : 'Sem contato' }}
                            </th>
                            <td>
                                <span class="badge" style="background-color: {{ $item->tag ? $item->tag->color : '#000' }}">{{ $item->tag ? $item->tag->name : 'Sem tag' }}</span>

                            <td>
                                {{ $item->template ? $item->template->name : 'Sem template' }}
                            <td>
                                {{ $item->created_at ? Carbon\Carbon::parse($item->created_at)->format('d/m/y H:i') : 'Sem data' }}
                            </td>
                            <td>
                                {{ $item->send_at ? Carbon\Carbon::parse($item->send_at)->format('d/m/Y H:i:s') : 'Não enviado' }}
                            </td>
                            
                            <td>
                                @switch($item->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pendente</span>
                                        @break
                                    @case('sent')
                                        <span class="badge bg-success">Enviado</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Falha</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    <script>

        let table = new DataTable('#table', {
            responsive: true
        });

    </script>

    @endsection
    
@endsection