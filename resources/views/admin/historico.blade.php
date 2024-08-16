@extends('layouts.layout')

@section('title', 'Página Inicial')

@section('content')
    <h1 class="app-page-title">Histórico</h1>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Destino</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Template</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Enviado em</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <th scope="row">
                                5531994359434
                            </th>
                            <td>
                                <span class="badge bg-success">Enviado</span>
                            </td>
                            <td>grupo1</td>
                            <td>template1</td>
                            <td>
                                20/09/2021 10:00:00
                            </td>
                            <td>
                                20/09/2021 10:00:00
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection