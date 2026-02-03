<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>FastFoodSystem - Menú</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon">

  <style>
    body {
      background-image: url('/FastFoodSystem/assets/images/Menú.png');
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      display: flex;
      justify-content: center;
      padding: 30px 15px;
      flex-wrap: wrap;
    }

    #flipbook {
      width: 100%;
      max-width: 700px;
      aspect-ratio: 16 / 11;
      position: relative;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .page {
      background: #ffffff;
      border: 1px solid #e0c27c;
      border-radius: 12px;
      padding: 30px;
      box-sizing: border-box;
      color: #3e2d1c;
      font-family: 'Georgia', serif;
      font-size: 17px;
      line-height: 1.6;
      overflow: hidden;
      height: 480px;
    }

    .page h1 {
      font-family: 'Segoe UI', sans-serif;
      font-size: 36px;
      color: #3e2d1c;
      text-align: center;
      margin-top: 10px;
      border-bottom: 2px solid #e7b850;
      padding-bottom: 10px;
    }

    .page h2 {
      font-size: 22px;
      color: #a0742f;
      border-bottom: 1px dashed #e7b850;
      padding-bottom: 4px;
      margin-top: 30px;
    }

    .page ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .page li {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin: 12px 0;
      padding: 5px 0;
      border-bottom: 1px dotted #ddd1a8;
    }

    .page li span.name {
      font-weight: bold;
      color: #3e2d1c;
      font-size: 17px;
      flex: 1;
    }

    .page li span.price {
      font-weight: bold;
      color: #a67c00;
      margin-left: 10px;
      white-space: nowrap;
    }

    .page li small {
      font-size: 14px;
      color: #756b5a;
      display: block;
      margin-top: 4px;
    }

    .portada {
      text-align: center;
    }

    .img-portada {
      width: 70%;
      max-width: 300px;
      border-radius: 10px;
      margin-top: 20px;
    }

    .navegacion {
      text-align: center;
      margin: 30px 0 50px;
    }

    .navegacion button {
      background-color: #e7b850;
      color: #3e2d1c;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      margin: 0 10px;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .navegacion button:hover {
      background-color: #cfae40;
      transform: scale(1.05);
    }

    .contacto {
      margin-top: 25px;
      font-size: 18px;
      font-weight: bold;
      color: #a12f2f;
    }

    .btn-volver {
      position: fixed;
      top: 20px;
      left: 20px;
      background-color: #ffc107;
      color: #3e2d1c;
      font-weight: bold;
      padding: 12px 18px;
      border-radius: 12px;
      text-decoration: none;
      font-size: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
      z-index: 9999;
    }

    .btn-volver:hover {
      background-color: #e0a800;
      color: white;
      transform: scale(1.1) rotate(-1deg);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>

<body>

  <div class="container">
    <div id="flipbook">
      <div class="page portada">
        <h1>SA-VORA</h1>
        <p>"La comida que te hace feliz"</p>
        <img src="/FastFoodSystem/assets/images/Logo de rotisería sa-vora.png" alt="Logo" class="img-portada">
      </div>
    </div>
  </div>

  <div class="navegacion">
    <button onclick="$('#flipbook').turn('previous')">⬅ Anterior</button>
    <button onclick="$('#flipbook').turn('next')">Siguiente ➡</button>
  </div>

  <a href="/FastFoodSystem/index.php?controller=Cliente&action=home" class="btn-volver">← Volver a la página principal</a>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/FastFoodSystem/assets/js/turn.min.js"></script>
  <script src="/FastFoodSystem/assets/js/turn-script.js"></script>

  <script>
    $(document).ready(function() {
      $('#flipbook').turn({
        width: 700,
        height: 480,
        autoCenter: true,
        acceleration: true,
        gradients: true,
        elevation: 30,
        when: {
          turned: function() {
            window.scrollTo(0, 0);
          }
        }
      });

      $(window).on('resize', function() {
        const width = Math.min(window.innerWidth * 0.95, 700);
        const height = width * 0.685;
        $('#flipbook').turn('size', width, height);
      }).trigger('resize');
    });
  </script>
</body>