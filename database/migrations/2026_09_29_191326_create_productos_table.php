<?php 
  
use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 
  
return new class extends Migration 
{ 
      public function up(): void 
    { 
        Schema::create('productos', function (Blueprint $table) { 
            $table->id(); 
            $table->string('nombre', 150); 
            $table->text('descripcion')->nullable(); 
            $table->unsignedInteger('cantidad')->default(0); 
            $table->decimal('precio_unitario', 10, 2); 
            $table->foreignId('categoria_id') 
                  ->constrained('categorias') 
                  ->onDelete('restrict'); 
            $table->timestamps(); 
        }); 
    } 
  
    public function down(): void 
    { 
        Schema::dropIfExists('productos'); 
    } 
}; 