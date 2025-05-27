<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\CategoriaProducto;

class ProductoController extends Controller
{
    // Mostrar formulario de creación
    public function create()
    {
        $categorias = CategoriaProducto::all();
        return view('crear-producto', compact('categorias'));
    }

    // Guardar producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombreProducto' => 'required|string|max:150',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'descripcion' => 'nullable|string',
            'idCategoria' => 'required|exists:CategoriaProducto,idCategoria',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Guardar imagen en /storage/app/public/productos
        $ruta = $request->file('imagen')->store('productos', 'public');

        Producto::create([
            'nombreProducto' => $request->nombreProducto,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
            'idCategoria' => $request->idCategoria,
            'image_url' => $ruta,
            'disponible' => true
        ]);

        return redirect('/productos')->with('success', 'Producto creado con éxito');
    }
}
