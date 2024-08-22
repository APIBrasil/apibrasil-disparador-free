@extends('layouts.layout')

@section('title', 'Dispositivos')

@section('content')
    <h1 class="app-page-title">Dispositivos</h1>

    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-12">
            <button class="btn btn-primary float-end text-white" onclick="createItem()">Cadastrar</button>
        </div>

        <div class="col-12 col-lg-12">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-striped table-hover mb-0 table-responsive" id="table">

                        <thead>
                        <tr>
                            <th scope="col">Device</th>
                            <th scope="col">DeviceToken</th>
                            <th scope="col">Número</th>
                            <th scope="col">API</th>
                            <th scope="col">Cadastrado</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 200px">Ações</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalItem" tabindex="-1" aria-labelledby="modalItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalItemLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row g-4 mb-4">

                        <div class="col-3">
                            <label for="secretkey" class="form-label">Secret key</label>
                            <select class="form-select" id="secretkey" name="secretkey" required>
                                @foreach($apis as $api)
                                    <option value="{{$api->secretkey}}">{{ $api->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="cellphone">Celular</option>
                                <option value="tablet">Tablet</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="server_search" class="form-label">Server search</label>
                            <select class="form-select" id="server_search" name="server_search" required>
                                <option value="">Selecione</option>
                                @foreach($servidores as $servidor)
                                <option value="{{ $servidor->server_search }}">{{ $servidor->servername }} - {{ $servidor->limit_used ?? 0 }}% usado</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="device_name" class="form-label">Device name</label>
                            <input type="text" class="form-control" id="device_name" name="device_name" required>
                        </div>

                        <div class="col-3">
                            <label for="device_key" class="form-label">Device key</label>
                            <input type="tel" class="form-control" id="device_key" name="device_key" required>
                        </div>

                        <div class="col-3">
                            <label for="device_ip" class="form-label">Device ip</label>
                            <input type="tel" class="form-control" id="device_ip" name="device_ip" placeholder="0.0.0.0" required>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalQR" tabindex="-1" aria-labelledby="modalQRLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <form class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalQRLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">

                    <div class="text-center">
                        <img src="https://loja.maxineo.com.br/wp-content/uploads/2017/10/loading.gif" alt="" class="w-50">
                    </div>

                    <p id="message" class="text-center">Aguarde...</p>

                </div>
            </form>
        </div>
    </div>

    @section('scripts')

    <script>

        let token = document.querySelector('meta[name="bearer_token_api_brasil"]').getAttribute('content');
        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let profile_id = document.querySelector('meta[name="profile_id"]').getAttribute('content');

        let table = new DataTable('#table', {
            responsive: true,
            ajax: '/dispositivos/datatables',
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
            columns: 
            [
                { data: 'device_name', name: 'device_name' },
                { data: 'device_token', name: 'device_token' },
                { data: 'number_device', name: 'number_device' },
                { data: 'service.name', name: 'service.name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' }
            ],
            columnDefs:
            [
                {
                    targets: 5,
                    render: function (data, type, row) {
                       
                        switch (data) {
                            case 'inChat':
                            case 'CONNECTED':
                                return `<span class="badge bg-success">${data}</span>`;
                                break;
                            case 'browserClose':
                                return `<span class="badge bg-danger">${data}</span>`;
                                break;
                            default:
                                return `<span class="badge bg-warning">${data}</span>`;
                                break;
                        }

                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YY HH:mm');
                    }
                },
                {
                    targets: 6,
                    render: function (data, type, row) {
                        let btnEdit= `<button class="btn btn-primary" onclick="getItems(${row.id})"><i class="fa fa-edit"></i></button>`;
    
                        let btnStart = `<button class="btn btn-success" onclick="startDevice('${row.device_token}')"><i class="fa fa-qrcode"></i></button>`;
                        if(row.status == 'inChat' || row.status == 'CONNECTED' || row.status == 'open') {
                            btnStart = "";
                        }
                     
                        let btnDelete = `<button class="btn btn-danger" onclick="deleteItem(${row.id})"><i class="fa fa-trash"></i></button>`;

                        return `${btnEdit} ${btnStart} ${btnDelete}`;
                    }
                }
            ]

        });

        const startDevice = (device_token) => {
            
            const socket = io('https://socket.apibrasil.com.br', {
                query: {
                    channelName: profile_id, 
                    bearer: token
                }
            });

            socket.on('connect', () => {
                console.log(`O cliente ${socket.id} se conectou!`);
            });

            socket.on(`${device_token}`, (events) => {

                document.getElementById('message').innerHTML = events?.data?.message?.message ? events.data.message.message : 'Aguarde...';

                if (events.data.wook == 'QRCODE') {

                    let base64 = events.data.qrcode;
                    let image = document.createElement('img');

                    image.src = base64;
                    image.className = 'w-100';

                    document.querySelector('#modalQR .modal-body').innerHTML = '';
                    document.querySelector('#modalQR .modal-body').appendChild(image);
                }

                if (events.data.status == 'inChat') {

                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Dispositivo conectado com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'Fechar',
                    });

                    const myModalQR = bootstrap.Modal.getInstance(document.getElementById('modalQR'));
                    myModalQR.hide();

                    window.location.reload();

                }

            });

            const myModalQR = new bootstrap.Modal('#modalQR', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalQRLabel').innerHTML = `Obtendo QR Code ...`;
            myModalQR.show();

            fetch(`/dispositivos/${device_token}/start`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _token: _token })
            })
            .then(response => response.json())
            .then(data => {
                
                if (data.error == true) {

                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao iniciar dispositivo!',
                        icon: 'error',
                        confirmButtonText: 'Fechar',
                    });

                    myModalQR.hide();

                }

            })
            .catch((error) => {
                
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao iniciar dispositivo!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

                console.error('Error:', error);
                
            });

        }

        const createItem = () => {

            document.getElementById('device_name').value = '';
            document.getElementById('device_key').value = '';
            document.getElementById('device_ip').value = '';
            document.getElementById('type').value = 'cellphone';
            document.getElementById('server_search').value = '';

            const myModal = new bootstrap.Modal('#modalItem', {
                keyboard: false,
                backdrop: 'static'
            });

            document.getElementById('modalItemLabel').innerHTML = 'Cadastrar dispositivo';
            document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `saveItem()`);

            myModal.show();

        }

        const saveItem = async () => {

            let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var selectElement = document.getElementById('templates_id');

            document.querySelector('#modalItem .modal-footer button').setAttribute('disabled', 'disabled');

            const bodyData = JSON.stringify({
                _token: _token,
                device_name: document.getElementById('device_name').value,
                device_key: document.getElementById('device_key').value,
                device_ip: document.getElementById('device_ip').value,
                type: document.getElementById('type').value,
                server_search: document.getElementById('server_search').value,
                secretkey: document.getElementById('secretkey').value
            });

            fetch('/dispositivos/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: bodyData
            })
            .then(response => response.json())
            .then(data => {
                
                if (data.error == true) {

                    if (data.message) {

                        let messages = '';
                        for (const [key, value] of Object.entries(data.message)) {
                            for (const [k, v] of Object.entries(value)) {
                                messages += v + "\n";
                            }
                        }

                        Swal.fire({
                            title: 'Erro!',
                            text: messages ? messages : 'Erro ao salvar item!',
                            icon: 'error',
                            confirmButtonText: 'Fechar',
                        });

                    } else {

                        Swal.fire({
                            title: 'Erro!',
                            text: 'Erro ao salvar item!',
                            icon: 'error',
                            confirmButtonText: 'Fechar',
                        });

                    }
                    

                } else {

                    const myModal = bootstrap.Modal.getInstance(document.getElementById('modalItem'));
                    myModal.hide();
                    location.reload();

                }

                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');

            })
            .catch((error) => {

                let messages = '';
                for (const [key, value] of Object.entries(error)) {
                    messages += value + '<br>';
                }

                Swal.fire({
                    title: 'Erro!',
                    text: messages ? messages : 'Erro ao salvar item!',
                    icon: 'error',
                    confirmButtonText: 'Fechar',
                });

                document.querySelector('#modalItem .modal-footer button').removeAttribute('disabled');
                console.error('Error:', error);

            });

        }

        const getItems = (id) => {

            fetch(`/dispositivos/${id}/show`)
            .then(response => response.json())
            .then(data => {
                
                const myModalAlternative = new bootstrap.Modal('#modalItem', {
                    keyboard: false,
                    backdrop: 'static'
                });

                document.getElementById('modalItemLabel').innerHTML = `Editar item ${data.name}`;

                document.getElementById('type').value = data.type;
                document.getElementById('server_search').value = data.server_search;
                document.getElementById('device_name').value = data.device_name;
                document.getElementById('device_key').value = data.device_key;
                document.getElementById('device_ip').value = data.device_ip;
                document.getElementById('secretkey').value = data.service.search;

                myModalAlternative.show();
                document.querySelector('#modalItem .modal-footer button').setAttribute('onclick', `updateItem('${id}')`);
                
                console.log(data);
            });

        }

        const updateItem = async (id) => {

            let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const bodyData = JSON.stringify({
                _token: _token,
                device_name: document.getElementById('device_name').value,
                device_key: document.getElementById('device_key').value,
                device_ip: document.getElementById('device_ip').value,
                type: document.getElementById('type').value,
                server_search: document.getElementById('server_search').value,
                secretkey: document.getElementById('secretkey').value,
            });

            fetch(`/dispositivos/${id}/update`, {
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

            fetch(`/dispositivos/${id}/destroy`, {
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