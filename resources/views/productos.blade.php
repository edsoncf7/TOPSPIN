<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catálogo TopSpin Bolivia</title>
  <link href="{{ asset('css/productos.css') }}" rel="stylesheet">

</head>
<body>

<header>
  <!-- Logo -->
  <div class="logo-container">
    <img src="{{ asset('img/logotopspin.jpg') }}" alt="TopSpin Logo" class="logo" />
  </div>

  <!-- Menú de navegación -->
  <nav class="main-nav">
    <a href="#">INICIO</a>
    <a href="#">QUIENES SOMOS</a>
    <a href="#">MANTENIMIENTO</a>
    @auth
      <a href="/citas">Agendar cita</a>
      <a href="/logout">Cerrar sesión</a>
    @else
      <a href="/register">Registrarse</a>
    @endauth
  </nav>

  <!-- Buscador + carrito -->
  <div class="search-cart">
    <div class="search-box">
      <input type="search" placeholder="Buscar producto..." />
      <button aria-label="Buscar">&#128269;</button>
    </div>
    <div class="cart">
      🛒 Total: {{ count($products) }} productos
    </div>
  </div>

  <!-- Ícono de usuario arriba a la derecha -->
  @guest
  <div class="user-login-icon">
    <a href="/login" class="user-login-icon">
      <img src="{{ asset('img/usuario.png') }}" alt="Login" />
    </a>
  </div>
  @endguest
</header>


<div class="container">
  <aside>
    <h3>Categoría</h3>
    <ul>
      <li>Raquetas
        <ul>
          <li>Raquetball</li>
          <li>Tenis</li>
          <li>Padel</li>
        </ul>
      </li>
      <li>Cuerdas
        <ul>
          <li>E-Force</li>
          <li>Wilson</li>
          <li>Dunlop</li>
          <li>Tecnifibre</li>
          <li>Gama</li>
          <li>Gearbox</li>
        </ul>
      </li>
      <li>Guantes
        <ul>
          <li>Gearbox</li>
          <li>E-force</li>
          <li>Dunlop</li>
          <li>Prokenex</li>
        </ul>
      </li>
      <li>Favoritos</li>
    </ul>
  </aside>

  <main>
    <h2>Todos los productos</h2>
    <div class="product-grid">
      <!-- Productos cargados dinámicamente aquí -->
      @foreach ($products as $product)
        <div class="product-card">
          <div class="fav-icon" title="Agregar a favoritos"></div>

          {{-- Muestra la imagen del producto --}}
          <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->nombreProducto }}">

          <div class="product-name">{{ $product->nombreProducto }}</div>
          <div class="product-price">
            Bs. {{ number_format($product->precio, 2) }}
          </div>
          <button class="btn-add-cart">Añadir al carrito</button>
          <div class="details-link">Ver detalles</div>
        </div>
      @endforeach

    </div>
  </main>
</div>
<script>
  const userBtn = document.getElementById('userBtn');
  const userDropdown = document.getElementById('userDropdown');

  userBtn.addEventListener('click', () => {
    const expanded = userBtn.getAttribute('aria-expanded') === 'true' || false;
    userBtn.setAttribute('aria-expanded', !expanded);
    if (userDropdown.hasAttribute('hidden')) {
      userDropdown.removeAttribute('hidden');
    } else {
      userDropdown.setAttribute('hidden', '');
    }
  });

  // Cerrar menú al hacer clic fuera
  document.addEventListener('click', (event) => {
    if (!userBtn.contains(event.target) && !userDropdown.contains(event.target)) {
      userDropdown.setAttribute('hidden', '');
      userBtn.setAttribute('aria-expanded', false);
    }
  });
</script>

</body>
</html>
