<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
        }
        .email-body p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .discount-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .discount-label {
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .discount-code {
            background-color: #ffffff;
            color: #667eea;
            font-size: 32px;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 8px;
            display: inline-block;
            letter-spacing: 3px;
            margin: 10px 0;
        }
        .discount-percentage {
            color: #ffffff;
            font-size: 48px;
            font-weight: bold;
            margin: 10px 0;
        }
        .expiry {
            color: #ffffff;
            font-size: 14px;
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            background-color: #667eea;
            color: #ffffff;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎉 ¡Bienvenido de vuelta!</h1>
        </div>
        <div class="email-body">
            <p>Hola,</p>
            <p>¡Nos alegra verte de nuevo! Como agradecimiento por iniciar sesión, hemos preparado un regalo especial para ti.</p>
            
            <div class="discount-box">
                <div class="discount-label">Tu código de descuento</div>
                <div class="discount-percentage">{{ $discountCode->discount_percentage }}% OFF</div>
                <div class="discount-code">{{ $discountCode->code }}</div>
                <div class="expiry">⏰ Válido hasta: {{ $discountCode->expires_at->format('d/m/Y H:i') }}</div>
            </div>

            <p><strong>¿Cómo usar tu código?</strong></p>
            <p>1. Añade productos a tu carrito<br>
               2. Ve al checkout<br>
               3. Ingresa el código en el campo "Código de descuento"<br>
               4. ¡Disfruta de tu descuento!</p>

            <center>
                <a href="{{ config('app.url') }}" class="btn">Explorar Productos</a>
            </center>

            <p>¡No esperes más! Este código es exclusivo para ti y tiene fecha de caducidad.</p>
        </div>
        <div class="email-footer">
            <p>Este es un correo automático. Por favor, no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} eCommerce Laravel. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
