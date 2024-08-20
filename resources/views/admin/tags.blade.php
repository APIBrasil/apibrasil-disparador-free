@extends('layouts.layout')

@section('title', 'Tags')

@section('content')
    <h1 class="app-page-title">Tags</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" onclick="createItem()"><i class="fas fa-user-plus"></i> Nova tag</button>
            <a href="/contatos" class="btn btn-info float-end text-white me-2"><i class="fa fa-backward"></i> Voltar</a>
        </div>

        <div class="col-12 col-lg-12">


            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive" id="table">
                        <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Contatos</th>
                            <th scope="col">Cor</th>
                            <th scope="col" style="width: 200px">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $tag)
                        <tr>
                            <th scope="row">
                                {{ $tag->id }}
                            </th>
                            <th scope="row">
                                <a href="#" onclick="getItems({{ $tag->id }})">{{ $tag->name }}</a>
                            </th>
                            <td>
                                {{ $tag->description }}
                            </td>
                            <td>
                                {{ $tag->contatos ? count($tag->contatos) : 0 }}
                            </td>
                            <td>
                                <span class="badge" style="background: {{ $tag->color }}">{{ $tag->color }}</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white" onclick="getItems({{ $tag->id }})"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white" onclick="deleteItem({{ $tag->id }})"><i class="fas fa-trash"></i></a>
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

                    <div class="col-12">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="col-6">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="col-3">
                        <label for="color" class="form-label">Cor</label>
                        <input type="color" class="form-control" id="color" name="color" required>
                    </div>

                    <div class="col-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
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

        let table = new DataTable('#table', {
            responsive: true
        });

        const getItems = (id) => {

        fetch(`/tags/${id}/show`)
        .then(response => response.json())
        .then(data => {
            
            const myModalAlternative = new bootstrap.Modal('#modalItem', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalItemLabel').innerHTML = `Editar item ${data.name}`;

            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('color').value = data.color;
            document.getElementById('status').value = data.status;

            myModalAlternative.show();

            document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `updateItem(${id})`);
            
            console.log(data);
        });

        }

        const createItem = () => {

            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('color').value = '#000000';
            document.getElementById('status').value = 'active';

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
            description: document.getElementById('description').value,
            color: document.getElementById('color').value,
            status: document.getElementById('status').value,
        });

        fetch('/tags/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: bodyData
        })
        .then(response => response.json())
        .then(data => {
            
            if (data.error == true) {

                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

            } else {

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
            description: document.getElementById('description').value,
            color: document.getElementById('color').value,
            status: document.getElementById('status').value,
        });

        fetch(`/tags/${id}/update`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: bodyData
        })

        .then(response => response.json())

        .then(data => {
            
            if (data.error == true) {

                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

            } else {

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

        fetch(`/tags/${id}/destroy`, {
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