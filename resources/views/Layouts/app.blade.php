<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Gestión de Productos - SENA</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
rel="stylesheet"> 
</head> 
<body> 
    <nav class="navbar navbar-expand navbar-dark bg-dark"> 
        <div class="container"> 
            <a class="navbar-brand" href="{{ route('categorias.index') }}">Gestión 
Comercial</a> 
            <div class="navbar-nav"> 
                <a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a> 
                <a class="nav-link" href="{{ route('productos.index') }}">Productos</a> 
            </div> 
        </div> 
    </nav> 
  
    @yield('content') 
  
    <script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body> 
</html> 