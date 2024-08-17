@extends('layouts.layout')

@section('title', 'Contatos')

@section('content')
    <h1 class="app-page-title">Contatos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" onclick="createItem()"><i class="fas fa-user-plus"></i></button>
            <button class="btn btn-primary float-end text-white me-2" onclick="uploadItem()"><i class="fas fa-upload"></i></button>
            <a href="/tags" class="btn btn-info float-end text-white me-2"><i class="fas fa-list"></i> Tags</a>
        </div>

        <div class="col-12 col-lg-12">


            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive table-responsive-large" id="example1">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Número</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($contatos as $contato)
                        <tr>
                            <th scope="row">
                                <a href="#" onclick="getItems({{ $contato->id }})">{{ $contato->name }}</a>
                            </th>
                            <td>
                                {{ $contato->number }}
                            </td>
                            <td>
                                {{  $contato->tag ? $contato->tag->name : 'Sem tag' }}
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white" onclick="getItems({{ $contato->id }})"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white" onclick="deleteItem({{ $contato->id }})"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="modalItem" tabindex="-1" aria-labelledby="modalItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalItemLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row g-4 mb-4">

                    <div class="col-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="col-3">
                        <label for="number" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="number" name="number" required>
                    </div>

                    <div class="col-6">
                        <label for="tag_id" class="form-label">Tag</label>
                        <select class="form-select" id="tag_id" name="tag_id" required>
                            <option value="">Selecione uma tag</option>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary text-white">Salvar</button>
            </div>
            </div>
        </div>
    </div>

    @section('scripts')

    <script>

        const getItems = (id) => {

        fetch(`/contatos/${id}/show`)
        .then(response => response.json())
        .then(data => {
            
            const myModalAlternative = new bootstrap.Modal('#modalItem', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalItemLabel').innerHTML = `Editar item ${data.name}`;

            document.getElementById('name').value = data.name;
            document.getElementById('number').value = data.number;
            document.getElementById('tag_id').value = data.tag_id;

            myModalAlternative.show();

            document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `updateItem(${id})`);
            
            console.log(data);
        });

        }

        const createItem = () => {

        document.getElementById('name').value = '';
        document.getElementById('number').value = '';
        document.getElementById('tag_id').value = '';

        const myModal = new bootstrap.Modal('#modalItem', {
            keyboard: false,
            backdrop: 'static'
        });

        document.getElementById('modalItemLabel').innerHTML = 'Adicionar item';
        document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `saveItem()`);

        myModal.show();

        }

        const saveItem = async () => {

        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const bodyData = JSON.stringify({
            _token: _token,
            name: document.getElementById('name').value,
            number: document.getElementById('number').value,
            tag_id: document.getElementById('tag_id').value,
        });

        fetch('/contatos/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: bodyData
        })
        .then(response => response.json())
        .then(data => {
            
            if (data.error != 'true') {
                const myModal = bootstrap.Modal.getInstance(document.getElementById('modalItem'));
                myModal.hide();

                location.reload();
            }

        })
        .catch((error) => {
            console.error('Error:', error);
        });

        }

        const updateItem = async (id) => {

        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const bodyData = JSON.stringify({
            _token: _token,
            name: document.getElementById('name').value,
            number: document.getElementById('number').value,
            tag_id: document.getElementById('tag_id').value,
        });

        fetch(`/contatos/${id}/update`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: bodyData
        })

        .then(response => response.json())

        .then(data => {
            
            if (data.error != 'true') {
                const myModal = bootstrap.Modal.getInstance(document.getElementById('modalItem'));
                myModal.hide();

                location.reload();
            }

        })
        .catch((error) => {
            console.error('Error:', error);
        });

        }

        const deleteItem = async (id) => {

        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const bodyData = JSON.stringify({
            _token: _token
        });

        fetch(`/contatos/${id}/destroy`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: bodyData
        })

        .then(response => response.json())

        .then(data => {
            
            if (data.error != 'true') {
                location.reload();
            }

        })
        .catch((error) => {
            console.error('Error:', error);
        });

        }

    </script>

    @endsection
    
@endsection