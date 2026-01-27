<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
            background: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .amount {
            font-size: 32px;
            font-weight: bold;
            color: #0d6efd;
            text-align: center;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .button:hover {
            background: #157347;
        }
        .footer {
            background: #e9ecef;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-radius: 0 0 5px 5px;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 Confirma tu Compra</h1>
    </div>
    
    <div class="content">
        <h2>Hola, {{ $paymentConfirmation->user->name }}!</h2>
        
        <p>Has iniciado una compra que supera los 100 €. Por seguridad, necesitamos que confirmes esta transacción.</p>
        
        <div class="amount">
            {{ number_format($paymentConfirmation->amount, 2) }} €
        </div>
        
        <div class="center">
            <a href="{{ $confirmUrl }}" class="button">
                ✓ Confirmar Compra
            </a>
        </div>
        
        <div class="warning">
            <strong>⚠️ Importante:</strong>
            <ul>
                <li>Este enlace expira en <strong>24 horas</strong></li>
                <li>Solo puedes usarlo una vez</li>
                <li>Si no reconoces esta compra, ignora este correo</li>
            </ul>
        </div>
        
        <p style="margin-top: 30px; font-size: 14px; color: #6c757d;">
            Si no puedes hacer clic en el botón, copia y pega este enlace en tu navegador:<br>
            <a href="{{ $confirmUrl }}">{{ $confirmUrl }}</a>
        </p>
    </div>
    
    <div class="footer">
        <p>Este correo fue enviado desde <strong>PixelPlay</strong></p>
        <p>No respondas a este correo. Es generado automáticamente.</p>
        <p>Expira el: {{ $paymentConfirmation->expires_at->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
