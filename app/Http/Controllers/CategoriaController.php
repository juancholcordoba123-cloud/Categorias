<?php 
  
namespace App\Http\Controllers; 
  
use App\Models\Categoria; 
use Illuminate\Http\RedirectResponse; 
use Illuminate\Http\Request; 
use Illuminate\View\View; 
  
class CategoriaController extends Controller 
{ 
    public function index(): View 
    { 
        $categorias = Categoria::withCount('productos') 
            ->orderBy('nombre') 
            ->paginate(10); 
  
        return view('categorias.index', compact('categorias')); 
    } 
  
    public function store(Request $request): RedirectResponse 
    { 
        $datos = $request->validate([ 
            'nombre'      => ['required', 'string', 'max:100', 'unique:categorias,nombre'], 
            'descripcion' => ['nullable', 'string', 'max:500'], 
        ], [ 
            'nombre.required' => 'El nombre de la categoría es obligatorio.', 
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.', 
        ]);
            Categoria::create($datos); 
  
        return redirect()->route('categorias.index') 
            ->with('exito', 'Categoría creada correctamente.'); 
    } 
  
    public function update(Request $request, Categoria $categoria): RedirectResponse 
    { 
        $datos = $request->validate([ 
            'nombre'      => ['required', 'string', 'max:100', 'unique:categorias,nombre,' 
. $categoria->id], 
            'descripcion' => ['nullable', 'string', 'max:500'], 
        ], [ 
            'nombre.required' => 'El nombre de la categoría es obligatorio.', 
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.', 
        ]); 
  
        $categoria->update($datos); 
  
        return redirect()->route('categorias.index') 
            ->with('exito', 'Categoría actualizada correctamente.'); 
    } 
  
    public function destroy(Categoria $categoria): RedirectResponse 
    { 
        if ($categoria->productos()->exists()) { 
            return redirect()->route('categorias.index') 
                ->with('error', 'No se puede eliminar: la categoría tiene productos 
asociados.'); 
        } 
  
        $categoria->delete(); 
              return redirect()->route('categorias.index') 
            ->with('exito', 'Categoría eliminada correctamente.'); 
    } 
} 