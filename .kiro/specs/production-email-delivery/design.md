# Production Email Delivery Bugfix Design

## Overview

Este bug se manifiesta en el entorno de producción donde Laravel reporta envíos de email exitosos en los logs, pero los emails nunca llegan a los destinatarios. El problema NO está en el código PHP/Laravel (que funciona correctamente), sino en la **infraestructura SMTP o configuración del servidor de correo**. 

Los logs de producción muestran mensajes como:
- `✅ Correo enviado correctamente a usuario registrado: ferxxo.maman@gmail.com`
- `✅ Email manual enviado exitosamente al tutor: darkzeus842@gmail.com`

Sin embargo, estos emails no llegan a las bandejas de entrada. La estrategia de fix incluye diagnóstico profundo de la infraestructura SMTP, verificación de configuración de producción, validación de autenticación DNS (SPF/DKIM/DMARC), y mejora del logging para capturar errores reales de SMTP.

## Glossary

- **Bug_Condition (C)**: La condición que dispara el bug - cuando se envía un email en producción que Laravel reporta como exitoso pero no llega al destinatario
- **Property (P)**: El comportamiento deseado - los emails deben llegar a las bandejas de entrada de los destinatarios con los logs mostrando confirmación real del servidor SMTP
- **Preservation**: El comportamiento existente de notificaciones FCM (Firebase) que funciona correctamente y no debe ser afectado
- **MAIL_MAILER**: Variable de entorno en `.env` que define el driver de email (smtp, log, array, etc.)
- **Queue Workers**: Procesos de Laravel que ejecutan jobs de cola (queue), incluyendo envío de emails
- **SPF/DKIM/DMARC**: Registros DNS de autenticación de email que previenen que emails sean marcados como spam
- **Mailhog**: Servidor SMTP de desarrollo que captura emails sin enviarlos (usado en local)
- **Mail::send()**: Método facade de Laravel para enviar emails
- **SMTP (Simple Mail Transfer Protocol)**: Protocolo estándar para envío de emails
- **False Positive Success**: Cuando Laravel reporta éxito pero el email no fue realmente enviado por el servidor SMTP

## Bug Details

### Bug Condition

El bug se manifiesta cuando un email se envía en el entorno de producción mediante cualquiera de los métodos de envío del sistema (Mail::send(), Mail::to()->send(), etc.). Laravel registra un mensaje de éxito en los logs, pero el email nunca llega al buzón del destinatario. El sistema no está capturando errores reales de SMTP, lo que resulta en "falsos positivos" de éxito.

**Formal Specification:**
```
FUNCTION isBugCondition(input)
  INPUT: input of type EmailSendAttempt {
    environment: string,
    mailDriver: string,
    recipientEmail: string,
    loggedSuccess: boolean,
    actualDelivery: boolean
  }
  OUTPUT: boolean
  
  RETURN input.environment == 'production'
         AND input.loggedSuccess == true
         AND input.actualDelivery == false
         AND input.mailDriver IN ['smtp', 'sendmail', 'mailgun', 'ses', 'postmark']
END FUNCTION
```

### Examples

**Ejemplo 1: Email de notificación de tutoría a estudiante**
- **Esperado**: Email llega a ferxxo.maman@gmail.com con detalles de la tutoría programada
- **Actual**: Log muestra `✅ Correo enviado correctamente a usuario registrado: ferxxo.maman@gmail.com` pero el email no llega

**Ejemplo 2: Email manual a tutor**
- **Esperado**: Email llega a darkzeus842@gmail.com con información administrativa
- **Actual**: Log muestra `✅ Email manual enviado exitosamente al tutor: darkzeus842@gmail.com` pero el email no llega

**Ejemplo 3: Email de confirmación de reserva a estudiante**
- **Esperado**: Email llega a mamanidiego842@gmail.com con confirmación de reserva
- **Actual**: Log muestra `✅ Email manual enviado exitosamente al estudiante: mamanidiego842@gmail.com` pero el email no llega

**Ejemplo 4 (Edge Case): Email a dirección inválida**
- **Esperado**: Laravel debería detectar el error SMTP y registrar un fallo
- **Actual**: Posiblemente muestra éxito incluso con dirección inválida debido a falta de validación real de SMTP

## Expected Behavior

### Preservation Requirements

**Unchanged Behaviors:**
- El sistema de notificaciones FCM (Firebase Cloud Messaging) debe continuar funcionando perfectamente como lo hace actualmente en producción
- Los emails en el entorno de desarrollo/local con Mailhog deben seguir funcionando
- La lógica de negocio que decide cuándo enviar emails no debe cambiar
- Los templates de email y contenido HTML deben permanecer idénticos
- Los destinatarios, asuntos y contenidos de los emails no deben modificarse

**Scope:**
Todos los flujos que NO involucran el envío real de emails a través de SMTP en producción deben permanecer completamente inalterados. Esto incluye:
- Notificaciones push FCM a dispositivos móviles
- Envío de emails en entorno local/desarrollo
- Lógica de triggers para notificaciones (cuándo se decide enviar)
- Formato y contenido de las notificaciones
- Cualquier otro sistema de comunicación no relacionado con email SMTP

## Hypothesized Root Cause

Basado en la evidencia de logs mostrando éxito falso y emails no llegando, las causas más probables son:

1. **Configuración SMTP incorrecta o ausente en producción**:
   - El archivo `.env` de producción puede estar usando `MAIL_MAILER=log` en lugar de `MAIL_MAILER=smtp`
   - Esto haría que Laravel solo escriba los emails a logs en lugar de enviarlos realmente
   - O puede tener configuración SMTP con credenciales incorrectas/expiradas

2. **Problemas de autenticación DNS (SPF/DKIM/DMARC)**:
   - El dominio `classgoapp.com` puede no tener registros SPF/DKIM/DMARC configurados
   - Los servidores de email de los destinatarios (Gmail, Outlook) rechazan emails sin autenticación adecuada
   - Los emails pueden estar yendo directo a carpeta SPAM o siendo rechazados silenciosamente

3. **Queue Workers no procesando correctamente**:
   - Si `QUEUE_CONNECTION=database` en producción, los workers pueden no estar corriendo
   - Los jobs de email se encolan pero nunca se ejecutan
   - Laravel marca el job como "encolado exitosamente" pero nunca se procesa

4. **Servidor SMTP bloqueando o limitando envíos**:
   - El hosting en producción puede tener límites de tasa de envío
   - El puerto SMTP (465/587/25) puede estar bloqueado por el firewall
   - Credenciales SMTP pueden haber expirado o estar bloqueadas por el proveedor

5. **Falta de manejo de excepciones SMTP**:
   - Laravel puede no estar capturando excepciones de la capa SMTP (Swift_TransportException)
   - Los errores de conexión SMTP se silencian y se reportan como éxito
   - El timeout de SMTP (actualmente 5 segundos en config/mail.php) puede ser muy corto

6. **Servidor SMTP de desarrollo en producción**:
   - Si producción tiene `MAIL_HOST=127.0.0.1` y `MAIL_PORT=1025` (Mailhog), los emails no salen realmente
   - Mailhog solo captura emails para desarrollo, no los envía

## Correctness Properties

Property 1: Bug Condition - Real SMTP Delivery in Production

_For any_ email send attempt in production environment where valid SMTP configuration exists and recipient email is valid, the fixed system SHALL successfully deliver the email to the recipient's inbox (or spam folder if blocked), and logs SHALL reflect the true SMTP response code (success 250 or actual error codes like 550, 554, 421).

**Validates: Requirements 2.1, 2.2, 2.3**

Property 2: Preservation - Non-Email Notifications

_For any_ notification that is NOT an email (FCM push notifications, SMS, in-app notifications), the fixed code SHALL produce exactly the same behavior as the original code, preserving all existing functionality for non-email communication channels.

**Validates: Requirements 3.1, 3.2**

## Fix Implementation

### Changes Required

Asumiendo que el análisis de causa raíz es correcto, los cambios se dividen en verificación, diagnóstico y corrección:

**Fase 1: Diagnóstico y Verificación**

**File**: `.env` (producción - requiere acceso SSH/FTP al servidor)

**Verificación Requerida**:
1. **Confirmar MAIL_MAILER**: Verificar si está usando `log`, `array` o `smtp`
2. **Validar credenciales SMTP**: Si es `smtp`, verificar HOST, PORT, USERNAME, PASSWORD
3. **Revisar QUEUE_CONNECTION**: Verificar si es `sync` o `database`
4. **Confirmar FROM address**: Verificar que `MAIL_FROM_ADDRESS` sea un email válido del dominio

**File**: Nuevo archivo `app/Console/Commands/TestSmtpConnection.php`

**Specific Changes**:
1. **Crear comando artisan de diagnóstico SMTP**:
   - Comando: `php artisan mail:test-smtp {email}`
   - Realiza conexión real al servidor SMTP sin enviar desde la aplicación
   - Valida autenticación, TLS/SSL, y capacidad de envío
   - Reporta errores específicos de SMTP con códigos de respuesta
   - Intenta enviar un email de prueba y captura el resultado real

2. **Mejorar logging de errores SMTP**:
   - Capturar excepciones `Swift_TransportException` y `Swift_RfcComplianceException`
   - Registrar el código de respuesta SMTP completo en logs
   - Agregar contexto: timestamp, destinatario, servidor SMTP usado
   - Diferenciar entre "encolado" y "enviado realmente"

**File**: `config/mail.php`

**Specific Changes**:
3. **Aumentar timeout SMTP**:
   - Cambiar de `'timeout' => 5` a `'timeout' => 30`
   - Permite que conexiones más lentas completen sin timing out

**File**: Servicios de envío de email (`app/Services/MailService.php`, `app/Services/BookingNotificationService.php`, `app/Services/TutorVerificationNotificationService.php`)

**Specific Changes**:
4. **Agregar try-catch robusto con logging detallado**:
   ```php
   try {
       Mail::to($user->email)->send($mailable);
       Log::info('✅ Email REALMENTE enviado', [
           'recipient' => $user->email,
           'smtp_response' => 'success',
           'mailer' => config('mail.default')
       ]);
   } catch (\Swift_TransportException $e) {
       Log::error('❌ Error SMTP al enviar email', [
           'recipient' => $user->email,
           'error' => $e->getMessage(),
           'smtp_code' => $e->getCode(),
           'mailer' => config('mail.default')
       ]);
       throw $e; // Re-lanzar para que el error sea visible
   }
   ```

5. **Verificar que queue workers estén corriendo** (si QUEUE_CONNECTION=database):
   - Documentar comando para iniciar: `php artisan queue:work --tries=3`
   - Agregar supervisord/systemd config para mantener workers activos
   - Monitorear cola con: `php artisan queue:monitor`

**Fase 2: Correcciones de Configuración (basadas en diagnóstico)**

**Corrección A: Si MAIL_MAILER=log en producción**
- Cambiar a `MAIL_MAILER=smtp` en `.env` de producción
- Configurar credenciales SMTP válidas

**Corrección B: Si faltan registros DNS SPF/DKIM/DMARC**
- Agregar registro SPF: `v=spf1 a mx include:_spf.smtp-provider.com ~all`
- Configurar DKIM en el proveedor SMTP
- Agregar registro DMARC: `v=DMARC1; p=quarantine; rua=mailto:postmaster@classgoapp.com`

**Corrección C: Si queue workers no están corriendo**
- Iniciar workers con: `php artisan queue:work --daemon`
- Configurar supervisor para auto-restart

**Corrección D: Si credenciales SMTP inválidas**
- Obtener nuevas credenciales del proveedor SMTP
- Actualizar MAIL_USERNAME y MAIL_PASSWORD en `.env`

**Corrección E: Si puerto bloqueado**
- Probar puerto alternativo (587 en lugar de 465, o 25)
- Contactar hosting para desbloquear puertos SMTP

## Testing Strategy

### Validation Approach

La estrategia de testing sigue un enfoque de tres fases: primero, realizar diagnóstico exploratorio para confirmar/refutar las hipótesis de causa raíz; segundo, implementar la corrección y verificar que emails lleguen realmente; tercero, validar que notificaciones FCM siguen funcionando (preservation).

### Exploratory Bug Condition Checking

**Goal**: Confirmar la causa raíz del bug ANTES de implementar el fix. Identificar cuál de las 6 hipótesis es la correcta ejecutando diagnósticos en el código UNFIXED y la infraestructura de producción actual.

**Test Plan**: Ejecutar el comando de diagnóstico SMTP en producción y analizar logs actuales. Revisar configuración real de `.env` en producción. Verificar registros DNS. Comprobar estado de queue workers.

**Test Cases**:
1. **Verificación de MAIL_MAILER**: Ejecutar `php artisan tinker` en producción y evaluar `config('mail.default')` (esperamos encontrar 'log' o configuración incorrecta)
2. **Test de conexión SMTP**: Ejecutar `php artisan mail:test-smtp test@gmail.com` (esperamos fallo de conexión o autenticación)
3. **Revisar carpeta SPAM**: Solicitar a usuarios que revisen carpetas de SPAM (esperamos encontrar emails si el problema es DNS)
4. **Verificar queue jobs**: Ejecutar `php artisan queue:monitor` (esperamos encontrar jobs pendientes no procesados)
5. **Revisar logs de servidor**: Acceder a logs del servidor SMTP si es accesible (esperamos encontrar errores de autenticación o límites de tasa)
6. **Verificar registros DNS**: Usar herramienta MXToolbox para validar SPF/DKIM (esperamos encontrar registros ausentes)

**Expected Counterexamples**:
- MAIL_MAILER configurado como 'log' en producción, explicando por qué emails no se envían
- O SMTP_HOST apuntando a 127.0.0.1:1025 (Mailhog) en producción
- O ausencia total de registros SPF/DKIM/DMARC causando rechazo silencioso
- O queue workers detenidos con jobs acumulados en la tabla `jobs`

### Fix Checking

**Goal**: Verificar que para todos los intentos de envío de email donde la configuración está correcta, el email llega realmente al destinatario y los logs reflejan el estado real de entrega.

**Pseudocode:**
```
FOR ALL emailAttempt WHERE isBugCondition(emailAttempt) DO
  // Aplicar fix (configurar SMTP correctamente)
  result := sendEmailWithFixedConfig(emailAttempt)
  
  // Verificar que email llega realmente
  ASSERT emailArrivedInInbox(emailAttempt.recipient) 
         OR emailArrivedInSpam(emailAttempt.recipient)
  
  // Verificar que logs reflejan realidad
  ASSERT logs.contains(realSmtpResponseCode)
  ASSERT NOT logs.contains(falsePositiveSuccess)
END FOR
```

**Test Plan**:
1. Aplicar corrección identificada en fase exploratoria
2. Enviar email de prueba desde producción usando `php artisan mail:test-smtp`
3. Confirmar recepción real en buzón del destinatario (inbox o spam)
4. Revisar logs para verificar que muestran el código de respuesta SMTP real (250 OK)

### Preservation Checking

**Goal**: Verificar que para todos los sistemas de notificación que NO son email SMTP, el comportamiento permanece exactamente igual después del fix.

**Pseudocode:**
```
FOR ALL notification WHERE NOT (notification.type == 'email') DO
  ASSERT sendNotification_original(notification) 
         = sendNotification_fixed(notification)
END FOR
```

**Testing Approach**: Property-based testing es recomendado para preservation checking porque:
- Genera muchos casos de prueba automáticamente a través del dominio de entradas
- Captura edge cases que tests manuales unitarios podrían perder
- Provee garantías fuertes de que el comportamiento está sin cambios para todas las notificaciones no-email

**Test Plan**: Observar comportamiento en código UNFIXED primero para notificaciones FCM, luego escribir property-based tests capturando ese comportamiento.

**Test Cases**:
1. **FCM Notifications Preservation**: Enviar 10 notificaciones FCM push y verificar que todas llegan correctamente a dispositivos móviles (observar en unfixed code, luego confirmar en fixed code)
2. **Email Templates Preservation**: Verificar que templates de email no han cambiado (comparación de archivos blade)
3. **Notification Triggers Preservation**: Verificar que los eventos que disparan notificaciones siguen siendo los mismos (crear reserva, aceptar tutoría, etc.)
4. **Queue Job Structure Preservation**: Verificar que jobs de notificación no-email siguen la misma estructura

### Unit Tests

- Test que verifica conexión SMTP con credenciales válidas (usando mock)
- Test que captura excepciones `Swift_TransportException` correctamente
- Test que valida formato de logs mejorados con códigos SMTP
- Test que verifica timeout aumentado permite conexiones más lentas
- Test de comando artisan `mail:test-smtp` con email válido e inválido

### Property-Based Tests

- Generar 100 intentos de envío de email con diferentes destinatarios válidos y verificar que todos llegan (o fallan con error real, no falso positivo)
- Generar 50 notificaciones FCM aleatorias y verificar que todas llegan correctamente (preservation)
- Generar 30 configuraciones SMTP diferentes y verificar que el comando de diagnóstico detecta correctamente cuáles son válidas e inválidas

### Integration Tests

- Test de flujo completo: crear reserva de tutoría → verificar que email llega al estudiante → verificar que FCM también llega
- Test de flujo de aceptación: tutor acepta solicitud → verificar que email llega al estudiante → verificar logs muestran código SMTP real
- Test de flujo de contraoferta: tutor hace contraoferta → verificar que email llega al estudiante → verificar que el contenido del email es correcto
- Test de manejo de errores: intentar enviar email con servidor SMTP apagado → verificar que se registra error real, no falso éxito
- Test de carpeta SPAM: enviar email desde dominio sin SPF/DKIM → verificar que se detecta como spam pero se registra la entrega real
