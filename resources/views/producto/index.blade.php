@extends('template')

@section('title', 'Productos')

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
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('productos.create') }}">
            <button type="button" class="btn btn-primary">Añadir Nuevo Producto</button></a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Productos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categorias</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                        <tr>
                            <td>
                                {{ $item->codigo }}
                            </td>
                            <td>
                                {{ $item->nombre }}
                            </td>
                            <td>
                                {{ $item->descripcion }}
                            </td>
                            <td>
                                @foreach ($item->categorias as $category)
                                    <div class="container">
                                        <div class="row">
                                            <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{ $category->caracteristica->nombre }}</span>
                                        </div>
                                    </div>                                    
                                @endforeach
                            </td>
                            
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('productos.edit',['producto' => $item]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verModal-{{ $item->id }}">Ver</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}">Eliminar</button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1" aria-labelledby="verModalLabel-{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="verModalLabel-{{ $item->id }}">Detalles del Producto</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label for=""><span class="fw-bolder">Descripcion: </span>{{ $item->descripcion }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label for=""><span class="fw-bolder">Fecha de Vencimiento: </span>{{ $item->fecha_vencimiento ? $item->fecha_vencimiento : 'No tiene' }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label for=""><span class="fw-bolder">Stock: </span>{{ $item->stock }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="fw-bolder">Imagen: </label>
                                            <div>
                                                @if ($item->img_path != null)
                                                    <img src="{{ Storage::url('public/productos/'.$item->img_path) }}" alt="{{ $item->nombre }}" class="img-fluid img-thumbnail border border-4 rounded">
                                                @else
                                                    <img src="" alt="{{ $item->nombre }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('producto.delete', ['producto' => $item])
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
