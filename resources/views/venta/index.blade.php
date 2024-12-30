@extends('template')

@section('title','Ventas')
    
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
    <h1 class="mt-4 text-center">Ventas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Ventas</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('ventas.create') }}">
            <button type="button" class="btn btn-primary">Añadir nueva Venta</button>
        </a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Ventas
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Comprobante</th>
                        <th>Cliente</th>
                        <th>Fecha y Hora</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($ventas as $item)
                        <tr>
                            <td>
                                <p class="fw-semibold mb-1">{{ $item->comprobante->tipo_comprobante }}</p>
                                <p class="fw-semibold mb-0">{{ $item->numero_comprobante }}</p>
                            </td>
                            <td>
                                <p class="fw-semibold mb-1">{{ ucfirst($item->cliente->persona->tipo_persona) }}</p>
                                <p class="fw-semibold mb-0">{{ $item->cliente->persona->razon_social }}</p>
                            </td>
                            <td>
                                {{ 
                                    \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y') .'   '. 
                                    \Carbon\Carbon::parse($item->fecha_hora)->format('H:i')
                                }}
                            </td>
                            <td>
                                {{ $item->user->name }}
                            </td>
                            <td>
                                {{ $item->total }}
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('vemtas.show', ['venta'=>$item]) }}" method="get">
                                        <button type="submit" class="btn btn-success">Ver</button>
                                    </form>
                                    
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}">Eliminar</button>

                                </div>
                            </td>
                        </tr>
                        @include('venta.delete', ['venta' => $item])
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