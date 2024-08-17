@extends('layouts.layout')

@section('title', 'Dispositivos')

@section('content')
    <h1 class="app-page-title">Dispositivos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="fas fa-plus"></i> Adicionar</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Device</th>
                            <th scope="col">Device Token</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">API</th>
                            <th scope="col">Status</th>
                            <th scope="col">Cadastrado</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($dispositivos as $item)
                        <tr>

                            <th scope="row">
                                {{ $item->device_name }}
                            </th>
                            <td>
                                {{ $item->device_token }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->type }}</span>
                            <td>
                                {{ $item->service->name }}
                            <td>

                                @switch($item->status)
                                    @case('CONNECTED')
                                    <span class="badge bg-success">connected</span>
                                    @break
                                    @case('close')
                                    <span class="badge bg-danger">closed</span>
                                    @break
                                    @case('browserClose')
                                    <span class="badge bg-danger">browserClose</span>
                                    @break
                                    @case('refused')
                                    <span class="badge bg-danger">refused</span>
                                    @break
                                    @default
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                @endswitch


                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </td>

                            <td>
                                <a href="#" class="btn btn-sm btn-primary text-white"><i class="fas fa-qrcode"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection