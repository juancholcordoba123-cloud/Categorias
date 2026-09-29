<?php 
  
namespace App\Models; 
  
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
  
class Producto extends Model 
{ 
    use HasFactory; 
  
    protected $fillable = [ 
        'nombre', 'descripcion', 'cantidad', 'precio_unitario', 'categoria_id', 
    ]; 
      protected $casts = [ 
        'precio_unitario' => 'decimal:2', 
        'cantidad' => 'integer', 
    ]; 
  
    public function categoria(): BelongsTo 
    { 
        return $this->belongsTo(Categoria::class); 
    } 
} 