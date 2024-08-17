@extends('layouts.layout')

@section('title', 'Templates')

@section('content')
    <h1 class="app-page-title">Templates</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary text-white float-end" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="fas fa-plus"></i> Adicionar</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Mensagem</th>
                            <th scope="col">Arquivo</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">
                                Template 1
                            </th>
                            <td>
                                Template de teste
                            </td>
                            <td>Texto</td>
                            <td>
                                Olá, tudo bem?
                            </td>
                            <td>
                                <a href="#">Não tem arquivo</a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>
                            </td>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Template 2
                            </th>
                            <td>
                                Template de teste
                            </td>
                            <td>Imagem</td>
                            <td>
                                Olá, tudo bem?
                            </td>
                            <td>
                                <a href="#">Baixar arquivo</a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Template 3
                            </th>
                            <td>
                                Template de teste
                            </td>
                            <td>Arquivo</td>
                            <td>
                                Olá, tudo bem?
                            </td>
                            <td>
                                <a href="#">Baixar arquivo</a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    
@endsection