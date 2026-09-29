<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos.
     */
    public function index(): View
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->paginate(10);

        $categorias = Categoria::orderBy('nombre')->get();

        return view(
            'productos.index',
            compact('productos', 'categorias')
        );
    }

    /**
     * Reglas de validación.
     */
    private function reglas(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],

            'cantidad' => [
                'required',
                'integer',
                'min:0',
            ],

            'precio_unitario' => [
                'required',
                'numeric',
                'min:0',
            ],

            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    private function mensajes(): array
    {
        return [
            'nombre.required' =>
                'El nombre del producto es obligatorio.',

            'nombre.max' =>
                'El nombre no puede superar los 150 caracteres.',

            'descripcion.max' =>
                'La descripción no puede superar los 500 caracteres.',

            'cantidad.required' =>
                'La cantidad es obligatoria.',

            'cantidad.integer' =>
                'La cantidad debe ser un número entero.',

            'cantidad.min' =>
                'La cantidad no puede ser negativa.',

            'precio_unitario.required' =>
                'El precio unitario es obligatorio.',

            'precio_unitario.numeric' =>
                'El precio debe ser un número.',

            'precio_unitario.min' =>
                'El precio no puede ser negativo.',

            'categoria_id.required' =>
                'Debe seleccionar una categoría.',

            'categoria_id.exists' =>
                'La categoría seleccionada no es válida.',
        ];
    }

    /**
     * Crear un nuevo producto.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            $this->reglas(),
            $this->mensajes()
        );

        Producto::create($datos);

        return redirect()
            ->route('productos.index')
            ->with(
                'exito',
                'Producto creado correctamente.'
            );
    }

    /**
     * Actualizar producto mediante PUT/PATCH.
     */
    public function update(
        Request $request,
        Producto $producto
    ): RedirectResponse {

        $datos = $request->validate(
            $this->reglas(),
            $this->mensajes()
        );

        $producto->update($datos);

        return redirect()
            ->route('productos.index')
            ->with(
                'exito',
                'Producto actualizado correctamente.'
            );
    }

    /**
     * Actualizar producto mediante POST.
     */
    public function actualizar(
        Request $request,
        Producto $producto
    ): RedirectResponse {

        $datos = $request->validate(
            $this->reglas(),
            $this->mensajes()
        );

        $producto->nombre = $datos['nombre'];

        $producto->descripcion =
            $datos['descripcion'] ?? null;

        $producto->cantidad =
            $datos['cantidad'];

        $producto->precio_unitario =
            $datos['precio_unitario'];

        $producto->categoria_id =
            $datos['categoria_id'];

        $producto->save();

        return redirect()
            ->route('productos.index')
            ->with(
                'exito',
                'Producto actualizado correctamente.'
            );
    }

    /**
     * Eliminar producto.
     */
    public function destroy(
        Producto $producto
    ): RedirectResponse {

        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with(
                'exito',
                'Producto eliminado correctamente.'
            );
    }
}