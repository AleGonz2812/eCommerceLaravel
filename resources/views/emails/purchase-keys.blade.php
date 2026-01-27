<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .key-item {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .product-name {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .key-code {
            background: #f0f0f0;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            letter-spacing: 2px;
            text-align: center;
            border-radius: 5px;
            margin: 10px 0;
            user-select: all;
        }
        .instructions {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .footer {
            text-align: center;
            color: #666;
            padding: 20px;
            font-size: 12px;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎮 PixelPlay</h1>
        <p>¡Gracias por tu compra!</p>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $purchaseData['userName'] }}</strong>,</p>
        
        <p>Tu pedido <strong>#{{ $purchaseData['orderId'] }}</strong> ha sido procesado con éxito. Aquí están tus keys:</p>

        @foreach($purchaseData['items'] as $item)
        <div class="key-item">
            <div class="product-name">{{ $item['name'] }}</div>
            <div>Cantidad: {{ $item['quantity'] }}</div>
            <div>Precio: €{{ number_format($item['price'], 2) }}</div>
            
            <div class="key-code">
                {{ $item['key'] }}
            </div>
            
            <small style="color: #666;">💡 Haz clic en la key para seleccionarla y copiarla</small>
        </div>
        @endforeach

        <div class="total">
            Total pagado: €{{ number_format($purchaseData['total'], 2) }}
        </div>

        <div class="instructions">
            <strong>📝 Instrucciones de uso:</strong>
            <ul>
                <li>Copia la key del producto</li>
                <li>Abre la plataforma correspondiente (Steam, Epic Games, etc.)</li>
                <li>Ve a "Activar un producto" o similar</li>
                <li>Pega tu key y disfruta</li>
            </ul>
        </div>

        <p><strong>⚠️ Importante:</strong></p>
        <ul>
            <li>Estas keys son de un solo uso</li>
            <li>Guarda este correo para futuras referencias</li>
            <li>Las keys no expiran</li>
            <li>Si tienes problemas, contáctanos</li>
        </ul>

        <p>¡Disfruta de tus juegos!</p>
        <p><strong>El equipo de PixelPlay</strong></p>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no respondas.</p>
        <p>© {{ date('Y') }} PixelPlay. Todos los derechos reservados.</p>
    </div>
</body>
</html>
