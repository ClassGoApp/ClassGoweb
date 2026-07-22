<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notificación ClassGo</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f0f0f0;">
    
    <!-- Container principal -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0f0f0; padding: 20px;">
        <tr>
            <td align="center">
                
                <!-- Card principal con bordes redondeados -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background: linear-gradient(135deg, #006B8A 0%, #0088B3 100%); border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    
                    <!-- Header con Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #006B8A 0%, #0088B3 100%); padding: 40px 24px 30px 24px; text-align: center;">
                            <img src="{{ $message->embed(storage_path('app/public/Tugoemail.png')) }}" 
                                 alt="ClassGo" 
                                 width="150" 
                                 height="auto"
                                 style="display: block; margin: 0 auto; max-width: 150px;" />
                        </td>
                    </tr>
                    
                    <!-- Contenido principal con marco negro interno -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #006B8A 0%, #0088B3 100%); padding: 0px 16px 20px 16px;">
                            
                            <!-- Marco negro interno -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #1a1a1a; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.5);">
                                
                                <!-- Encabezado dentro del marco negro -->
                                <tr>
                                    <td style="color: #ffffff; font-size: 14px; font-weight: bold; text-align: center; padding-bottom: 20px;">
                                        ⚡ NOTIFICACIÓN CLASSGO
                                    </td>
                                </tr>
                                
                                <!-- Caja de contenido turquesa -->
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #17a2a2; border-radius: 12px; padding: 24px;">
                                            <tr>
                                                <td style="color: #ffffff; font-size: 16px; line-height: 1.8; text-align: center; font-weight: 500;">
                                                    {!! $body !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Signature si existe -->
                                @if($signature)
                                <tr>
                                    <td style="padding-top: 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="color: #999999; font-size: 13px; line-height: 1.6; text-align: center;">
                                                    {!! nl2br($signature) !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                
                            </table>
                            
                        </td>
                    </tr>
                    
                    <!-- Espacio inferior del marco azul -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #006B8A 0%, #0088B3 100%); padding: 0 0 20px 0;">
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #0a4a5c; padding: 16px 24px; text-align: center; font-size: 11px; color: #aaaaaa;">
                            @if($copyright)
                                <p style="margin: 0 0 8px 0;">
                                    {!! nl2br($copyright) !!}
                                </p>
                            @else
                                <p style="margin: 0 0 8px 0;">
                                    &copy; {{ date('Y') }} ClassGo. Todos los derechos reservados.
                                </p>
                            @endif
                            <p style="margin: 0; color: #666666; font-size: 10px;">
                                Este es un correo automático.
                            </p>
                        </td>
                    </tr>
                    
                </table>
                
            </td>
        </tr>
    </table>
    
</body>
</html>
