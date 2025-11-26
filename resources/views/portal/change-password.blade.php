<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - SilverGym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .logo h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .logo p {
            font-size: 18px;
            opacity: 0.9;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .card h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .card p {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
        }

        .btn i {
            margin-right: 8px;
        }

        .requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .requirements h4 {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        .requirements ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirements li {
            padding: 5px 0;
            font-size: 13px;
            color: #666;
        }

        .requirements li i {
            color: #ff6b6b;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🏋️ SilverGym</h1>
            <p>Cambiar Contraseña</p>
        </div>

        <div class="card">
            <h2>Primera Conexión</h2>
            <p>Por seguridad, debes cambiar tu contraseña antes de continuar</p>

            <div class="alert">
                <i class="fas fa-info-circle"></i>
                Esta es tu primera vez iniciando sesión. Por favor, establece una nueva contraseña segura.
            </div>

            <div class="requirements">
                <h4><i class="fas fa-shield-alt"></i> Requisitos de la contraseña:</h4>
                <ul>
                    <li><i class="fas fa-check"></i> Mínimo 6 caracteres</li>
                    <li><i class="fas fa-check"></i> Debe confirmar la contraseña</li>
                    <li><i class="fas fa-check"></i> Usa una contraseña que puedas recordar fácilmente</li>
                </ul>
            </div>

            @if($errors->any())
                <div class="alert" style="background: #f8d7da; color: #721c24; border-left-color: #dc3545;">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('portal.change-password.post') }}">
                @csrf
                
                <div class="form-group">
                    <label for="new_password">
                        <i class="fas fa-key"></i> Nueva Contraseña
                    </label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        placeholder="Ingresa tu nueva contraseña"
                        required
                        autofocus
                        minlength="6"
                    >
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">
                        <i class="fas fa-key"></i> Confirmar Contraseña
                    </label>
                    <input 
                        type="password" 
                        name="new_password_confirmation" 
                        id="new_password_confirmation" 
                        placeholder="Confirma tu nueva contraseña"
                        required
                        minlength="6"
                    >
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Cambiar Contraseña y Continuar
                </button>
            </form>
        </div>
    </div>
</body>
</html>
