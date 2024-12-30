@extends('template')

@section('title','Clientes')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
@if (session('success'))
<script>
    let message = "{{ session('success') }}";
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1700,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: message
    });
</script>
@endif
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Clientes</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('clientes.create') }}">
            <button type="button" class="btn btn-primary">Añadir Nuevo Cliente</button></a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Clientes
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Documento</th>
                        <th>Tipo de Persona</th>
                        <th>Acciones</th>
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($clientes as $item)
                        <tr>
                            <td>{{ $item->persona->razon_social }}</td>
                            <td>{{ $item->persona->direccion }}</td>
                            <td>
                                <p class="fw-normal mb-1">{{ $item->persona->documento->tipo_documento }}</p>
                                <p class="text-muted mb-0">{{ $item->persona->numero_documento }}</p>
                            </td>
                            <td>{{ $item->persona->tipo_persona }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('clientes.edit',['cliente'=>$item]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}">Eliminar</button>
                                    
                                </div>
                            </td>
                        </tr>

                        @include('cliente.delete', ['cliente' => $item])
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>

</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
