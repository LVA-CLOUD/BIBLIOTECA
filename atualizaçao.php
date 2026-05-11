<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estamos Trabalhando</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
    }

    .container {
      max-width: 700px;
      padding: 20px;
    }

    .gif-container {
      margin: 25px auto;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
      max-width: 380px;
    }

    .gif-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    h1 {
      font-size: 2.7rem;
      margin-bottom: 10px;
      background: linear-gradient(to right, #ff0080, #00ffff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    p {
      font-size: 1.35rem;
      line-height: 1.5;
      opacity: 0.95;
    }

    .highlight {
      font-size: 1.8rem;
      font-weight: bold;
      color: #00ffcc;
      margin: 25px 0;
    }

    .footer {
      margin-top: 60px;
      font-size: 1rem;
      opacity: 0.6;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Estamos trabalhando!</h1>
    
    <div class="gif-container">
      <img src="./assets/img/LOGOS/meninadançando.webp" alt="Menina dançando">
    </div>

    <p>Estamos preparando novas atualizações<br>para deixar tudo ainda melhor.</p>
    
    <p class="highlight">Volte outra hora! 💃✨</p>

    <div class="footer">
      Obrigado pela paciência ❤️
    </div>
  </div>

</body>
</html>