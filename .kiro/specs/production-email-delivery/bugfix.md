# Bugfix Requirements Document

## Introduction

Este documento define los requisitos para solucionar un bug crítico en producción donde los emails no se envían correctamente. El sistema Laravel funciona correctamente en entorno local usando Mailpit, pero falla al enviar emails en producción usando SMTP (mail.classgoapp.com). Los emails afectados incluyen verificación de email y notificaciones de tutorías. El sistema funcionaba correctamente en el pasado, lo que indica una regresión o cambio en la configuración.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN el sistema intenta enviar un email de verificación de usuario en el entorno de producción THEN el email no llega al destinatario y no hay entrega exitosa

1.2 WHEN el sistema intenta enviar un email de notificación de tutoría (confirmación de reserva, recordatorio, etc.) en el entorno de producción THEN el email no llega al destinatario

1.3 WHEN el sistema está configurado con las credenciales SMTP de producción (MAIL_HOST=mail.classgoapp.com, MAIL_PORT=465, MAIL_ENCRYPTION=ssl) THEN los emails no se envían correctamente

1.4 WHEN se ejecuta cualquier operación que requiera envío de email en producción (registro de usuario, creación de tutoría, notificaciones) THEN el email falla silenciosamente o genera errores en los logs sin entregar el mensaje

### Expected Behavior (Correct)

2.1 WHEN el sistema intenta enviar un email de verificación de usuario en el entorno de producción THEN el sistema SHALL enviar el email exitosamente al destinatario usando la configuración SMTP de mail.classgoapp.com

2.2 WHEN el sistema intenta enviar un email de notificación de tutoría en el entorno de producción THEN el sistema SHALL enviar el email exitosamente al destinatario con el contenido correcto (confirmación, recordatorio, cancelación, etc.)

2.3 WHEN el sistema está configurado con las credenciales SMTP de producción válidas (MAIL_HOST=mail.classgoapp.com, MAIL_PORT=465, MAIL_ENCRYPTION=ssl) THEN el sistema SHALL establecer una conexión SMTP exitosa y enviar emails

2.4 WHEN se ejecuta cualquier operación que requiera envío de email en producción THEN el sistema SHALL enviar el email exitosamente y registrar el envío en los logs o confirmar la entrega

2.5 WHEN existe un error en el envío de email (credenciales incorrectas, servidor SMTP no disponible, configuración inválida) THEN el sistema SHALL registrar un error descriptivo en los logs y opcionalmente notificar al administrador

### Unchanged Behavior (Regression Prevention)

3.1 WHEN el sistema se ejecuta en entorno local con Mailpit (MAIL_MAILER=smtp, MAIL_HOST=127.0.0.1, MAIL_PORT=1025) THEN el sistema SHALL CONTINUE TO enviar emails correctamente capturados por Mailpit

3.2 WHEN se envían notificaciones FCM (Firebase Cloud Messaging) en producción THEN el sistema SHALL CONTINUE TO enviar notificaciones push exitosamente sin verse afectadas por cambios en la configuración de email

3.3 WHEN el sistema envía emails desde servicios específicos (MailService, BookingNotificationService, TutorVerificationNotificationService) THEN el sistema SHALL CONTINUE TO usar la misma lógica de negocio y plantillas de email existentes

3.4 WHEN se usa la fachada Mail de Laravel para enviar emails THEN el sistema SHALL CONTINUE TO usar la configuración definida en config/mail.php y las variables de entorno del archivo .env

3.5 WHEN el usuario completa el registro o realiza una acción que dispara un email THEN el sistema SHALL CONTINUE TO ejecutar la lógica de negocio completa sin fallar, incluso si el email no se envía (manejo de errores apropiado)

3.6 WHEN se envían emails a múltiples destinatarios (estudiante, tutor, administrador) desde diferentes eventos del sistema THEN el sistema SHALL CONTINUE TO respetar las reglas de negocio existentes sobre quién recibe qué tipo de notificación

## Bug Condition Analysis

### Bug Condition Function

```pascal
FUNCTION isBugCondition(X)
  INPUT: X of type EmailOperation {
    environment: String,        // "production" o "local"
    mailerConfig: SmtpConfig {  // Configuración SMTP
      host: String,
      port: Integer,
      encryption: String,
      username: String,
      password: String
    },
    emailType: String          // "verification", "booking_notification", etc.
  }
  OUTPUT: boolean
  
  // El bug ocurre cuando se intenta enviar email en producción
  RETURN X.environment = "production" 
         AND X.mailerConfig.host = "mail.classgoapp.com"
         AND X.mailerConfig.port = 465
         AND X.mailerConfig.encryption = "ssl"
END FUNCTION
```

### Property Specification - Fix Checking

```pascal
// Property: Email Delivery in Production
FOR ALL X WHERE isBugCondition(X) DO
  result ← sendEmail'(X)
  ASSERT result.delivered = true 
         AND result.smtp_connection_successful = true
         AND (result.error = null OR result.error_logged = true)
END FOR
```

Esta propiedad verifica que:
- El email se entrega exitosamente (`delivered = true`)
- La conexión SMTP se establece correctamente (`smtp_connection_successful = true`)
- Si hay un error, se registra apropiadamente en logs (`error_logged = true`)

### Preservation Property

```pascal
// Property: Preservation Checking
FOR ALL X WHERE NOT isBugCondition(X) DO
  ASSERT sendEmail(X) = sendEmail'(X)
END FOR
```

Esto garantiza que:
- Los emails en **local con Mailpit** siguen funcionando
- Las notificaciones **FCM** no se ven afectadas
- Otros mailers o configuraciones no relacionadas permanecen intactas

## Diagnostic Strategy

Para diagnosticar este bug de manera segura en un entorno de prueba sin enviar emails a destinatarios reales:

1. **Verificar Configuración SMTP**: Probar la conexión al servidor SMTP de producción sin enviar emails
2. **Validar Credenciales**: Confirmar que las credenciales SMTP son correctas y tienen permisos
3. **Analizar Logs de Producción**: Revisar logs existentes para identificar errores SMTP específicos
4. **Testing Local con Config de Producción**: Usar las variables de entorno de producción en local, pero con Mailpit u otro mailer de prueba para verificar que el código funciona
5. **Función de Diagnóstico Temporal**: Crear una función que intente conectar al SMTP y reporte el estado sin enviar emails reales
