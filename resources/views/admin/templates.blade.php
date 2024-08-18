@extends('layouts.layout')

@section('title', 'Templates')

@section('content')
    <h1 class="app-page-title">Templates</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary text-white float-end" onclick="createItem()"><i class="fas fa-plus"></i> Adicionar</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive table-responsive-large" id="table">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Mensagem</th>
                            <th scope="col">Arquivo</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($templates as $item)
                        <tr>
                            <th scope="row">
                                {{ $item->name }}
                            </th>
                            <td>
                                {{ $item->description }}
                            </td>
                            <td>
                                {{ $item->type }}
                            <td>
                                {{ Str::limit($item->text, 50) }}
                            </td>
                            <td>
                                @if ($item->path)
                                    <a href="{{ asset('storage/' . $item->path) }}" target="_blank">Ver arquivo</a>
                                @else
                                    Sem arquivo
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 'active')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary text-white" onclick="getItems('{{$item->id}}')"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-danger text-white" onclick="deleteItem('{{$item->id}}')"><i class="fas fa-trash"></i></a>
                            </td>
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
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="col-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="text">Texto</option>
                            <option value="image">Imagem</option>
                            <option value="file">Arquivo</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <label for="path" class="form-label">URL do arquivo</label>
                        <input type="url" class="form-control" id="path" name="path" required>
                    </div>

                    <div class="col-12">
                        <label for="text" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="text" name="text" required cols="10" rows="5" style="height: 400px;"></textarea>
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

            fetch(`/templates/${id}/show`)
            .then(response => response.json())
            .then(data => {
                
                const myModalAlternative = new bootstrap.Modal('#modalItem', {
                    keyboard: false,
                    backdrop: 'static'
                });

                document.getElementById('modalItemLabel').innerHTML = `Editar item ${data.name}`;

                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('type').value = data.type;
                document.getElementById('text').value = data.text;
                document.getElementById('status').value = data.status;
                document.getElementById('path').value = data.path;

                myModalAlternative.show();

                document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `updateItem(${id})`);
                
                console.log(data);
            });

        }

        const createItem = () => {

            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('type').value = 'text';
            document.getElementById('text').value = '';
            document.getElementById('path').value = '';
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
                type: document.getElementById('type').value,
                path: document.getElementById('path').value,
                status: document.getElementById('status').value,
                text: document.getElementById('text').value
            });

            fetch('/templates/store', {
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
                description: document.getElementById('description').value,
                type: document.getElementById('type').value,
                status: document.getElementById('status').value,
                path: document.getElementById('path').value,
                text: document.getElementById('text').value
            });

            fetch(`/templates/${id}/update`, {
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

            fetch(`/templates/${id}/destroy`, {
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