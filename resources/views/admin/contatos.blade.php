@extends('layouts.layout')

@section('title', 'Contatos')

@section('content')
    <h1 class="app-page-title">Contatos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" onclick="createItem()"><i class="fas fa-user-plus"></i></button>
            @if($tags->count() > 0)
            <button class="btn btn-primary float-end text-white me-2" onclick="uploadItem()"><i class="fas fa-upload"></i></button>
            @endif
            <a href="/tags" class="btn btn-info float-end text-white me-2"><i class="fas fa-list"></i> Tags</a>
        </div>

        <div class="col-12 col-lg-12">

            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif


            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}

                @if (session('error') == 'Erro ao salvar contatos!')
                <a href="/exemplo.csv" class="btn btn-primary text-white">Baixar modelo</a>
                @endif

            </div>
            @endif

            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 table-responsive" id="table">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Número</th>
                            <th scope="col">Tag</th>
                            <th scope="col" style="width: 200px">Ações</th>
                        </tr>
                        </thead>
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
                            <option value="">Selecione</option>
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

    <div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="post" action="/contatos/upload" enctype="multipart/form-data">
                
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUploadLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Atenção! O arquivo deve ser no formato a seguir <a href="/exemplo.csv">Clique aqui</a> para baixar o modelo.
                    </div>

                    <div class="row g-4 mb-4">

                        <div class="col-12">
                            <label for="file" class="form-label">Arquivo</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white">Fazer upload</button>
                </div>

            </form>
        </div>
    </div>

    @section('scripts')

    <script>
    let table = new DataTable('#table', {
            responsive: true,
            ajax: '/contatos/datatables',
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
                { data: 'name', name: 'name' },
                { data: 'number', name: 'number' },
                { data: 'tag.name', name: 'tag.name' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
            {
                targets: 2,
                render: function (data, type, row) {
                    return `<span class="badge" style="background-color: ${row.tag.color}"> ${row.tag.name}</span>`;
                },
            },
            {

                targets: 3,
                render: function (data, type, row) {
                    return `
                        <a href="#" class="btn btn-primary text-white" onclick="getItems(${row.id})"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-danger text-white" onclick="deleteItem(${row.id})"><i class="fas fa-trash"></i></a>
                    `;
                }
            }]
        });

        const uploadItem = () => {

            const myModalAlternative = new bootstrap.Modal('#modalUpload', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalUploadLabel').innerHTML = 'Upload de contatos';

            myModalAlternative.show();

            document.querySelector('#modalUpload .modal-footer button').setAttribute('onclick', `uploadFile()`);

        }

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
                
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

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
                
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

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