@extends('layouts.layout')

@section('title', 'Contatos')

@section('content')
    <h1 class="app-page-title">Contatos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="fas fa-plus"></i> Adicionar</button>
        </div>

        <div class="col-12 col-lg-12">


            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive table-responsive-large" id="example1">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">José</th>
                            <td>5531994359434</td>
                            <td>grupo1</td>
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