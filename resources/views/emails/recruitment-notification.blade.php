<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; }
        .header { text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 0.8em; text-align: center; color: #777; }
        .highlight { font-weight: bold; color: #007bff; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
           
            <p>Hay un nuevo postulante interesado en unirse a <span class="highlight">ClassGo</span>.</p>
        </div>
        <div class="content">
            <p><strong>Nombre completo:</strong> {{ $recruitment->full_name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $recruitment->email ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $recruitment->phone ?? 'No proporcionado' }}</p>
            {{-- <p><strong>Descripción/Área:</strong></p> --}}
            <p style="background: #fff; padding: 10px; border: 1px solid #eee;">{{ $recruitment->description ?? 'Sin descripción' }}</p>
            
            <p>El currículum vitae ha sido adjuntado a este correo electrónico.</p>
            
            <a href="{{ url('/admin/recruitment') }}" class="btn" style="color: #fff;" >Ver en el Panel Admin</a>
        </div>
        <div class="footer">
            <p>Este es un mensaje automático del sistema de reclutamiento de ClassGo.</p>
        </div>
    </div>
</body>
</html>
