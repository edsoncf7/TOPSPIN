<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Producto</title>
  <link href="{{ asset('css/productos.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h2>Agregar nuevo producto</h2>

    @if ($errors->any())
      <div style="color: red;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <label>Nombre:</label><br>
      <input type="text" name="nombreProducto" required><br><br>

      <label>Precio:</label><br>
      <input type="number" name="precio" step="0.01" required><br><br>

      <label>Stock:</label><br>
      <input type="number" name="stock" required><br><br>

      <label>Descripción:</label><br>
      <textarea name="descripcion"></textarea><br><br>

      <label>Categoría:</label><br>
      <select name="idCategoria" required>
        <option value="">Selecciona una categoría</option>
        @foreach ($categorias as $categoria)
          <option value="{{ $categoria->idCategoria }}">{{ $categoria->nombreCategoria }}</option>
        @endforeach
      </select><br><br>

      <label>Imagen del producto:</label><br>
      <input type="file" name="imagen" accept="image/*" required><br><br>

      <button type="submit">Guardar producto</button>
    </form>
  </div>
</body>
</html>
