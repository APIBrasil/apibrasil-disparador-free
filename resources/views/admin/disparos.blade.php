@extends('layouts.layout')

@section('title', 'Disparos')

@section('content')
    <h1 class="app-page-title">Disparos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="fab fa-whatsapp"></i> Novo disparo</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Pendentes</th>
                            <th scope="col">Enviadas</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row">
                                    Campanha 2
                                </th>
                                <td>
                                    Campanha de teste
                                </td>
                                <td>grupo2</td>
                                <td>10</td>
                                <td>5</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Editar</a>
                                    <a href="#" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    Campanha 1
                                </th>
                                <td>
                                    Campanha de teste
                                </td>
                                <td>grupo1</td>
                                <td>220</td>
                                <td>5</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Editar</a>
                                    <a href="#" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>
                       
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    
@endsection