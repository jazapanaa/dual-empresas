<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado - 403</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Asegúrate de que Tailwind esté compilado -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="text-center px-6 py-10 bg-white shadow-xl rounded-2xl max-w-lg">
    <img src="{{asset('/assets/images/403.png')}}">
    <p class="text-gray-500 mb-6">No tienes permisos para acceder a esta página. Si crees que esto es un error, comunícate con el administrador.</p>
    <a href="{{ url('/dashboard') }}"
       class="btn-primary">
        Volver al inicio
    </a>
</div>
</body>
</html>
