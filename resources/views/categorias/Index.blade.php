@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Gestión de Categorías</h2>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalCrear">
            + Nueva Categoría
        </button>

    </div>

    @if (session('exito'))
        <div class="alert alert-success">
            {{ session('exito') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <table class="table table-striped table-bordered">

        <thead>

            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th># Productos</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($categorias as $categoria)

                <tr>

                    <td>
                        {{ $categoria->id }}
                    </td>

                    <td>
                        {{ $categoria->nombre }}
                    </td>

                    <td>
                        {{ $categoria->descripcion }}
                    </td>

                    <td>
                        {{ $categoria->productos_count }}
                    </td>

                    <td>

                        <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditar{{ $categoria->id }}">
                            Editar
                        </button>

                        <form action="{{ route('categorias.destroy', $categoria) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta categoría?');">

                            @csrf

                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    type="submit">
                                Eliminar
                            </button>

                        </form>

                    </td>

                </tr>


                {{-- MODAL EDITAR CATEGORÍA --}}

                <div class="modal fade"
                     id="modalEditar{{ $categoria->id }}"
                     tabindex="-1">

                    <div class="modal-dialog">

                        <form action="{{ route('categorias.update', $categoria) }}"
                              method="POST"
                              class="modal-content">

                            @csrf

                            @method('PUT')

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Editar Categoría
                                </h5>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <label class="form-label">
                                    Nombre
                                </label>

                                <input type="text"
                                       name="nombre"
                                       class="form-control"
                                       value="{{ $categoria->nombre }}"
                                       required
                                       maxlength="100">


                                <label class="form-label mt-2">
                                    Descripción
                                </label>

                                <textarea name="descripcion"
                                          class="form-control"
                                          maxlength="500">{{ $categoria->descripcion }}</textarea>

                            </div>

                            <div class="modal-footer">

                                <button type="submit"
                                        class="btn btn-primary">
                                    Guardar
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center">

                        No hay categorías registradas.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    {{ $categorias->links() }}

</div>


{{-- MODAL CREAR CATEGORÍA --}}

<div class="modal fade"
     id="modalCrear"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('categorias.store') }}"
              method="POST"
              class="modal-content">

            @csrf

            <div class="modal-header">

                <h5 class="modal-title">
                    Nueva Categoría
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <label class="form-label">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}"
                       required
                       maxlength="100">

                @error('nombre')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror


                <label class="form-label mt-2">
                    Descripción
                </label>

                <textarea name="descripcion"
                          class="form-control"
                          maxlength="500">{{ old('descripcion') }}</textarea>

            </div>


            <div class="modal-footer">

                <button type="submit"
                        class="btn btn-primary">
                    Guardar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection