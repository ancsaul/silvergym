<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - SilverGym</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0099ff 0%, #0055ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .change-password-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 440px;
            width: 100%;
        }

        .change-password-header {
            background: linear-gradient(135deg, #ff8800 0%, #ff6600 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .change-password-header h1 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .change-password-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .change-password-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-size: 14px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 42px;
            color: #999;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff8800;
        }

        .btn-change {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff8800 0%, #ff6600 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-change:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 136, 0, 0.4);
        }

        .btn-change:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .password-requirements {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
            line-height: 1.6;
        }

        .password-requirements ul {
            margin-top: 8px;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <div class="change-password-header">
            <h1>Cambiar Contraseña</h1>
            <p>Por seguridad, debes cambiar tu contraseña antes de continuar</p>
        </div>
        <div class="change-password-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.change.post') }}">
                @csrf
                <div class="form-group">
                    <label for="current_password">Contraseña Actual</label>
                    <span class="input-icon">🔒</span>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="current_password" 
                        name="current_password" 
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="new_password">Nueva Contraseña</label>
                    <span class="input-icon">🔑</span>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="new_password" 
                        name="new_password" 
                        required
                    >
                    <div class="password-requirements">
                        La contraseña debe tener:
                        <ul>
                            <li>Mínimo 8 caracteres</li>
                            <li>Al menos una letra mayúscula</li>
                            <li>Al menos un número</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                    <span class="input-icon">🔑</span>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="new_password_confirmation" 
                        name="new_password_confirmation" 
                        required
                    >
                </div>

                <button type="submit" class="btn-change">Cambiar Contraseña</button>
            </form>
        </div>
    </div>
</body>
</html>
