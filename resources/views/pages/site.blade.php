<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Сайт на реконструкции</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Styles -->
  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .code {
      border-right: 2px solid;
      font-size: 26px;
      padding: 0 15px 0 15px;
      text-align: center;
    }

    .message {
      font-size: 18px;
      text-align: center;
    }
  </style>
</head>
<body>
<div class="container-fluid vh-100">
  <div class="row justify-content-center vh-100 align-content-center">
    <div class="code col-12">
      Упс | Сайт на реконструкции. В скором времени он заработает
    </div>
    <div class="message col-12" style="padding: 10px;">
      <a class="btn btn-dark rounded-0" href="{{ url('/') }}">Проверить работу</a>
    </div>
  </div>
</div>
</body>
</html>

