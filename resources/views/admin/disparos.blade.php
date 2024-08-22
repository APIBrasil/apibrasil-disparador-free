@extends('layouts.layout')

@section('title', 'Disparos')

@section('content')
    <h1 class="app-page-title">Disparos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" onclick="createItem()"><i class="fab fa-whatsapp"></i> Novo disparo</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 table-responsive" id="table">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Template</th>
                            <th scope="col">Pendentes</th>
                            <th scope="col">Enviadas</th>
                            <th scope="col">Modo</th>
                            <th scope="col" style="width: 200px">Ações</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        
        <div class="row mt-4">

            <div class="col-3 col-lg-4">

                <div class="alert alert-success" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Lento: Envia mensagens com intervalo de tempo, de 120 a 240 segundos, podendo ser bloqueado pelo WhatsApp.
                </div>
            </div>
            
            <div class="col-3 col-lg-4">

                <div class="alert alert-primary" role="alert">
                    <i class="fas fa-check"></i> Normal: Envia mensagens com intervalo de tempo, de 60 a 120 segundos, podendo ser bloqueado pelo WhatsApp.
                </div>

            </div>

            <div class="col-3 col-lg-4">
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-info-circle"></i> Agressivo: Envia mensagens com intervalo de tempo, de 10 a 30 segundos, podendo ser bloqueado pelo WhatsApp.
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

                    <div class="col-9">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="col-6">
                        <label for="tag_id" class="form-label">Tag de envio</label>
                        <select class="form-select" id="tag_id" name="tag_id" required>
                            <option value="">Selecione</option>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }} - {{ $tag->contatos->count() }} contatos</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Selecione</option>
                            <option value="pending">Pendente</option>
                            <option value="paused">Pausado</option>
                            <option value="finished">Finalizado</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="mode" class="form-label">Modo</label>
                        <select class="form-select" id="mode" name="mode" required>
                            <option value="normal">Normal</option>
                            <option value="slow">Lento</option>
                            <option value="agressive">Agressivo ⚠️</option>
                        </select>
                    </div>
                    
                    <div class="col-9">
                        <label for="templates_id" class="form-label">Templates</label>
                        <select class="form-select" id="templates_id" name="templates_id[]" multiple required>
                            @foreach ($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
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

        let table = new DataTable('#table', {
            responsive: true,
            ajax: '/disparos/datatables',
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
                { data: 'description', name: 'description' },
                { data: 'tag.name', name: 'tag.name' },
                { data: 'templates', name: 'templates' },
                { data: 'messages_pending_count', name: 'messages_pending_count' },
                { data: 'messages_sent_count', name: 'messages_sent_count' },
                { data: 'mode', name: 'mode' },
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
                        return data.map(template => {
                            return `<span class="badge bg-primary">${template.name}</span>`;
                        }).join(' ');
                    },
                },

                {
                    targets: 6,
                    render: function (data, type, row) {
                        if (data == 'normal') {
                            return `<span class="badge bg-primary">Normal</span>`;
                        } else if (data == 'slow') {
                            return `<span class="badge bg-success">Lento</span>`;
                        } else {
                            return `<span class="badge bg-danger">Agressivo</span>`;
                        }
                    },
                },

                {
                    targets: 7,
                    render: function (data, type, row) {
                        return `<button class="btn btn-sm btn-primary" onclick="getItems(${row.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="deleteItem(${row.id})"><i class="fas fa-trash"></i></button>`;
                    },
                },
            ]

        });

        const getItems = (id) => {

            const myModalAlternative = new bootstrap.Modal('#modalItem', {
                keyboard: false,
                backdrop: 'static'
            });

            myModalAlternative.show();

            fetch(`/disparos/${id}/show`)
            .then(response => response.json())
            .then(data => {
                
                document.getElementById('modalItemLabel').innerHTML = `Editar item ${data.name}`;

                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('tag_id').value = data.tag_id;

                var selectElement = document.getElementById('templates_id');
                for (var i = 0; i < selectElement.options.length; i++) {
                    selectElement.options[i].selected = false;
                }
                
                templates_id = data.templates_id.split(',');

                for (var i = 0; i < templates_id.length; i++) {
                    document.getElementById('templates_id').querySelector(`option[value="${templates_id[i]}"]`).selected = true;
                }

                document.getElementById('status').value = data.status;
                document.getElementById('mode').value = data.mode;

                document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `updateItem(${id})`);

            });

        }

        const createItem = () => {

            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('tag_id').value = '';
            document.getElementById('templates_id').value = '';
            document.getElementById('status').value = '';
            document.getElementById('mode').value = 'normal';

            const myModal = new bootstrap.Modal('#modalItem', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalItemLabel').innerHTML = 'Cadastrar disparo';
            document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `saveItem()`);

            myModal.show();

        }

        const saveItem = async () => {

            let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var selectElement = document.getElementById('templates_id');

            document.querySelector('#modalItem .modal-footer button').setAttribute('disabled', 'disabled');
  
            var selectedValues = [];

            // Iterando sobre as opções e verificando as selecionadas
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedValues.push(selectElement.options[i].value);
                }
            }

            const bodyData = JSON.stringify({
                _token: _token,
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                tag_id: document.getElementById('tag_id').value,
                templates_id:  selectedValues,
                status: document.getElementById('status').value,
                mode: document.getElementById('mode').value,
            });

            fetch('/disparos/store', {
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

                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');

            })
            .catch((error) => {

                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');

                console.error('Error:', error);
            });

        }

        const updateItem = async (id) => {

            let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var selectElement = document.getElementById('templates_id');

            //disabled button
            document.querySelector('#modalItem .modal-footer button').setAttribute('disabled', 'disabled');

            // Array para armazenar os valores selecionados
            var selectedValues = [];

            // Iterando sobre as opções e verificando as selecionadas
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedValues.push(selectElement.options[i].value);
                }
            }

            const bodyData = JSON.stringify({
                _token: _token,
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                tag_id: document.getElementById('tag_id').value,
                templates_id: selectedValues,
                status: document.getElementById('status').value,
                mode: document.getElementById('mode').value,
            });

            fetch(`/disparos/${id}/update`, {
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

                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');

            })
            .catch((error) => {

                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });
                
                console.error('Error:', error);
                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');

            });

        }

        const deleteItem = async (id) => {

        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const bodyData = JSON.stringify({
            _token: _token
        });

        fetch(`/disparos/${id}/destroy`, {
            method: 'DELETE',
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
                    text: 'Erro ao deletar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

            } else {

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