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

                    <table class="table table-striped table-hover mb-0 text-nowrap table-responsive" id="table">

                        <thead>
                        <tr>
                            <th scope="col">Device</th>
                            <th scope="col">Device Token</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">API</th>
                            <th scope="col">Status</th>
                            <th scope="col">Cadastrado</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($dispositivos as $item)
                        <tr>

                            <th scope="row">
                                {{ $item->device_name }}
                            </th>
                            <td>
                                {{ $item->device_token }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->type }}</span>
                            <td>
                                {{ $item->service->name }}
                            <td>

                                @switch($item->status)
                                    @case('CONNECTED')
                                    @case('inChat')
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                    @break
                                    @case('close')
                                    <span class="badge bg-danger">closed</span>
                                    @break
                                    @case('browserClose')
                                    <span class="badge bg-danger">browserClose</span>
                                    @break
                                    @case('refused')
                                    <span class="badge bg-danger">refused</span>
                                    @break
                                    @default
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                @endswitch


                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </td>

                            <td>
                                <a href="#" class="btn btn-sm btn-primary text-white"><i class="fas fa-qrcode"></i></a>
                                <a href="#" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>
                        </tr>
                        @endforeach
                        
                        </tbody>
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

    @section('scripts')

    <script>

        let table = new DataTable('#table', {
            responsive: true
        });

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

    </script>

    @endsection

@endsection