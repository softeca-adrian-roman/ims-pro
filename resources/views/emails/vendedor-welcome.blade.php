<!DOCTYPE html>
<head>
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #000000;
        }
        p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola {{ $name }}!</h1>
        <p>Tu cuenta ha sido creada con éxito en {{ config('app.name') }}.</p>
        <p>Puedes acceder con tu correo: <strong>{{ $email }}</strong> y la contraseña que estableciste.</p>
        <p>¡Gracias por unirte a IMS!</p>
    </div>
</body>
</html>
