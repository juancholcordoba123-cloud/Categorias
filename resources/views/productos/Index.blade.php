@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestión de Productos</h2>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalCrearProducto">
            + Nuevo Producto
        </button>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('exito'))
        <div class="alert alert-success">
            {{ session('exito') }}
        </div>
    @endif

    <table class="table table-striped table-bordered">

        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($productos as $producto)

                <tr>

                    <td>{{ $producto->id }}</td>

                    <td>{{ $producto->nombre }}</td>

                    <td>{{ $producto->categoria->nombre }}</td>

                    <td>{{ $producto->cantidad }}</td>

                    <td>
                        ${{ number_format($producto->precio_unitario, 2) }}
                    </td>

                    <td>

                        {{-- BOTÓN EDITAR --}}
                        <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarProducto{{ $producto->id }}">
                            Editar
                        </button>

                        {{-- BOTÓN ELIMINAR --}}
                        <form action="{{ route('productos.destroy', $producto) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar este producto?');">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    type="submit">
                                Eliminar
                            </button>

                        </form>

                    </td>

                </tr>


                {{-- ========================================= --}}
                {{-- MODAL EDITAR PRODUCTO                     --}}
                {{-- ========================================= --}}

                <div class="modal fade"
                     id="modalEditarProducto{{ $producto->id }}"
                     tabindex="-1"
                     aria-hidden="true">

                    <div class="modal-dialog">

                        {{-- FORMULARIO CORREGIDO --}}
                        <form action="{{ route('productos.actualizar', $producto) }}"
                              method="POST"
                              class="modal-content">

                            @csrf

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Editar Producto
                                </h5>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Cerrar">
                                </button>

                            </div>

                            <div class="modal-body">

                                {{-- NOMBRE --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Nombre
                                    </label>

                                    <input type="text"
                                           name="nombre"
                                           class="form-control"
                                           value="{{ $producto->nombre }}"
                                           required
                                           maxlength="150">

                                </div>


                                {{-- DESCRIPCIÓN --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Descripción
                                    </label>

                                    <textarea name="descripcion"
                                              class="form-control"
                                              maxlength="500"
                                              rows="3">{{ $producto->descripcion }}</textarea>

                                </div>


                                {{-- CANTIDAD --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Cantidad
                                    </label>

                                    <input type="number"
                                           name="cantidad"
                                           class="form-control"
                                           value="{{ $producto->cantidad }}"
                                           min="0"
                                           required>

                                </div>


                                {{-- PRECIO --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Precio Unitario
                                    </label>

                                    <input type="number"
                                           step="0.01"
                                           name="precio_unitario"
                                           class="form-control"
                                           value="{{ $producto->precio_unitario }}"
                                           min="0"
                                           required>

                                </div>


                                {{-- CATEGORÍA --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Categoría
                                    </label>

                                    <select name="categoria_id"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            -- Seleccione --
                                        </option>

                                        @foreach ($categorias as $categoria)

                                            <option value="{{ $categoria->id }}"
                                                @selected($categoria->id == $producto->categoria_id)>

                                                {{ $categoria->nombre }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


                            {{-- BOTONES --}}
                            <div class="modal-footer">

                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Cancelar
                                </button>

                                <button type="submit"
                                        class="btn btn-primary">
                                    Guardar cambios
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center">

                        No hay productos registrados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    {{ $productos->links() }}

</div>


{{-- ========================================= --}}
{{-- MODAL CREAR PRODUCTO                     --}}
{{-- ========================================= --}}

<div class="modal fade"
     id="modalCrearProducto"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <form action="{{ route('productos.store') }}"
              method="POST"
              class="modal-content">

            @csrf

            <div class="modal-header">

                <h5 class="modal-title">
                    Nuevo Producto
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar">
                </button>

            </div>


            <div class="modal-body">

                {{-- NOMBRE --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}"
                           required
                           maxlength="150">

                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- DESCRIPCIÓN --}}
                <div class="mb-3">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea name="descripcion"
                              class="form-control"
                              maxlength="500"
                              rows="3">{{ old('descripcion') }}</textarea>

                </div>


                {{-- CANTIDAD --}}
                <div class="mb-3">

                    <label class="form-label">
                        Cantidad
                    </label>

                    <input type="number"
                           name="cantidad"
                           class="form-control @error('cantidad') is-invalid @enderror"
                           value="{{ old('cantidad') }}"
                           min="0"
                           required>

                    @error('cantidad')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PRECIO --}}
                <div class="mb-3">

                    <label class="form-label">
                        Precio Unitario
                    </label>

                    <input type="number"
                           step="0.01"
                           name="precio_unitario"
                           class="form-control @error('precio_unitario') is-invalid @enderror"
                           value="{{ old('precio_unitario') }}"
                           min="0"
                           required>

                    @error('precio_unitario')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- CATEGORÍA --}}
                <div class="mb-3">

                    <label class="form-label">
                        Categoría
                    </label>

                    <select name="categoria_id"
                            class="form-select @error('categoria_id') is-invalid @enderror"
                            required>

                        <option value="">
                            -- Seleccione --
                        </option>

                        @foreach ($categorias as $categoria)

                            <option value="{{ $categoria->id }}"
                                @selected(old('categoria_id') == $categoria->id)>

                                {{ $categoria->nombre }}

                            </option>

                        @endforeach

                    </select>

                    @error('categoria_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit"
                        class="btn btn-primary">
                    Guardar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection