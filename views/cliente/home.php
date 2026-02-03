<?php
if (isset($_SESSION['usuario'])) {
  // Ya está logueado, redirigí a index.php para que use redirigirPorPerfil()
  header('Location: /FastFoodSystem/index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FastFoodSystem</title>
  <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root {
      --primary: #e7b850;
      /* Dorado suave */
      --secondary: #fff7e2;
      /* Fondo claro cálido */
      --accent: #f4e1b6;
      /* Crema claro */
      --brown: #3e2d1c;
      /* Marrón oscuro */
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--secondary);
      margin: 0;
    }

    /* Hero */
    .hero {
      position: relative;
      background-image: url('/FastFoodSystem/assets/images/Home.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      color: white;
      text-align: center;
      overflow: hidden;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.55);
      z-index: 1;
    }

    .hero .container {
      position: relative;
      z-index: 2;
      padding: 100px 20px;
      animation: fadeInDown 1.2s ease;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo-pequeno {
      width: 100px;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: var(--primary);
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    .hero p {
      font-size: 1.2rem;
      color: #fff;
    }

    .btn-group-hover-container {
      margin-top: 25px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
    }

    .btn-flip {
      padding: 10px 20px;
      font-weight: bold;
      color: var(--brown);
      background-color: var(--accent);
      border-radius: 10px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn-flip:hover {
      background-color: var(--primary);
      color: white;
    }

    /* Platos destacados */
    .featured-dishes {
      padding: 50px 20px;
    }

    .dish-card {
      background-color: #fffef9;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s;
    }

    .dish-card:hover {
      transform: scale(1.05);
    }

    .dish-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .dish-card .card-body {
      padding: 15px;
      color: var(--brown);
    }

    .section-title {
      text-align: center;
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 30px;
      color: var(--brown);
    }

    /* Info adicional */
    .info-extra {
      background-color: var(--accent);
      text-align: center;
      padding: 30px 20px;
      color: var(--brown);
    }

    .info-extra a {
      color: var(--brown);
      text-decoration: none;
    }

    .map-responsive {
      max-width: 500px;
      margin: 20px auto 0;
      border-radius: 10px;
      overflow: hidden;
    }

    .map-responsive iframe {
      width: 100%;
      height: 250px;
      border: 0;
    }

    .social-section {
      background-color: #FFF7E2;
      color: var(--brown);
      text-align: center;
      padding: 20px 10px;
    }

    .social-section .bi {
      font-size: 1.8rem;
      margin: 0 12px;
      transition: color 0.3s;
      color: var(--brown);
    }

    .social-section .bi:hover {
      color: #6a4a2b;
    }

    .whatsapp-float {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #25d366;
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      z-index: 99;
      transition: transform 0.2s ease;
    }

    .whatsapp-float:hover {
      transform: scale(1.1);
    }
  </style>

</head>

<body>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <img src="/FastFoodSystem/assets/images/Logo-Hamburguesa.png" alt="Logo SA-VORA" class="logo-pequeno mb-3">
      <h1>FastFoodSystem</h1>
      <p>La comida que te hace feliz</p>
      <div class="btn-group-hover-container">
        <a href="index.php?controller=Login&action=loginView" class="btn-flip">Iniciar sesión</a>
        <a href="index.php?controller=Cliente&action=registrar" class="btn-flip">Registrarse</a>
        <a href="index.php?controller=Cliente&action=verCarta" class="btn-flip">Ver carta</a>
      </div>
    </div>
  </section>

  <!-- Platos destacados -->
  <section class="featured-dishes container">
    <h2 class="section-title">Platos destacados</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="dish-card">
          <img src="https://static.vecteezy.com/system/resources/previews/023/809/530/non_2x/a-flying-burger-with-all-the-layers-ai-generative-free-photo.jpg" alt="Empanadas">
          <div class="card-body">
            <h5>Hamburguesas gourmet</h5>
            <p>Jugosas, completas y preparadas al momento. Con pan artesanal y combinaciones únicas, cada bocado es una experiencia rotisera.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dish-card">
          <img src="https://static.vecteezy.com/system/resources/previews/022/994/042/non_2x/the-pepperoni-pizza-and-a-piece-of-streched-cheese-pizza-with-ai-generated-free-photo.jpg" alt="Milanesa">
          <div class="card-body">
            <h5>Pizzas caseras</h5>
            <p>Masa casera, ingredientes frescos y el sabor irresistible de horno bien caliente. Nuestras pizzas combinan tradición con el toque justo de sabor moderno.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dish-card">
          <img src="https://static.vecteezy.com/system/resources/previews/001/903/393/non_2x/assorted-iced-drinks-free-photo.jpg" alt="Tartas">
          <div class="card-body">
            <h5>Bebidas & Cócteles</h5>
            <p>Refrescantes y perfectas para acompañar tu comida. Desde gaseosas bien frías hasta cócteles con un toque especial, tenemos lo que necesitás para brindar.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Info adicional -->
  <section class="info-extra">
    <h3>¡Realizá tu pedido!</h3>
    <p><i class="bi bi-telephone-fill"></i><a href="https://wa.me/5493705176505" target="_blank"> +54 3705-176505</a></p>
    <p><i class="bi bi-credit-card-2-back-fill"></i><strong> Alias MercadoPago: </strong>FAST.FOOD.COMIDAS</p>
    <img src="/FastFoodSystem/assets/images/MercadoPago.png" class="logo-pequeno" alt="Logo MP" />
    <p>
      <i class="bi bi-geo-alt-fill"></i>
      FastFood – Formosa, Argentina
    </p>

    <div class="map-responsive">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3577.420296098764!2d-58.1742151!3d-26.1869025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x945ca5f3d4b8b0b7%3A0x6d6d9c8b2c8c9f6a!2sPlaza%20San%20Mart%C3%ADn%2C%20Formosa%2C%20Argentina!5e0!3m2!1ses-419!2sar!4v1716679999999!5m2!1ses-419!2sar"
        loading="lazy">
      </iframe>

    </div>
  </section>

  <!-- Redes sociales -->
  <section class="social-section">
    <h2 class="section-title">¡Seguinos!</h2>
    <p>Enterate de promociones y nuevos sabores</p>
    <div class="d-flex justify-content-center mt-3">
      <a href="https://facebook.com" class="bi bi-facebook" target="_blank"></a>
      <a href="https://instagram.com" class="bi bi-instagram" target="_blank"></a>
      <a href="https://wa.me/5493705176505" class="bi bi-whatsapp" target="_blank"></a>
      <a href="mailto:fastfoodsystem@gastronomia.com" class="bi bi-envelope-fill"></a>
    </div>
  </section>

  <!-- Botón WhatsApp flotante -->
  <a href="https://wa.me/5493705176505" target="_blank" class="whatsapp-float" title="Escribinos">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>