# Informe QA - Bug de Entrega de Emails Masivos

## Fecha: 25 de Agosto, 2026
## Severidad: Alta
## Estado: ✅ Resuelto

---

## Problema Reportado

**Síntoma:**
Al verificar la identidad de un tutor desde el panel de administración, el sistema envía **570+ emails simultáneos** a todos los estudiantes registrados, causando que el servidor de correo:
- Marque el dominio como spam
- Bloquee entregas subsecuentes
- Genere errores: "Domain classgoapp.com has exceeded the max defers and failures per hour (78/20 (60%))"

**Impacto:**
- Correos legítimos no se entregan
- Reputación del dominio afectada
- Saturación del servidor de correo
- Mala experiencia de usuario

---

## Análisis de Causa Raíz

### Flujo Identificado:

1. **Admin verifica tutor** → `IdentityVerification.php` línea 101-143
2. Ejecuta: `notifyStudentsAboutTutorVerification($verifiedTutor)`
3. Llama a: `TutorVerificationNotificationService::notifyStudentsAboutTutorVerification()`
4. **Obtiene TODOS los estudiantes** (570 usuarios)
5. **Envía email + FCM** a cada uno:
   - Función `sendEmailToStudent()` (línea ~364)
   - Función `sendPushNotificationToStudent()` (línea ~408)
6. Aunque tiene control de lotes (10 por lote con delays), **570 emails en corto tiempo saturan el servidor**

### Código Problemático (ANTES):

```php
// TutorVerificationNotificationService.php - Línea ~334
private function sendNotificationToStudent(User $student, array $tutorInfo): void
{
    // ❌ Envía EMAIL (problema principal)
    $this->sendEmailToStudent($student, $tutorInfo);
    
    // Envía FCM
    $this->sendPushNotificationToStudent($student, $tutorInfo);
}
```

---

## Solución Implementada

### Estrategia:
**Deshabilitar emails masivos y usar SOLO notificaciones FCM (push notifications)**

### Justificación:
1. **FCM es instantáneo:** No tiene límite de envíos por hora
2. **Mejor deliverability:** Google maneja la infraestructura
3. **Mejor UX:** Click en notificación → Directo al perfil del tutor
4. **Sin spam:** No afecta reputación del dominio
5. **Trackeable:** Sabemos quiénes tienen FCM activo

---

## Cambios Realizados

### 1. Backend - Deshabilitar Emails Masivos

**Archivo:** `/home/diego/dev/web/php/ClassGoweb/app/Services/TutorVerificationNotificationService.php`

#### Cambio 1.1: Función `sendNotificationToStudent()` (línea ~334)
```php
// ANTES
private function sendNotificationToStudent(User $student, array $tutorInfo): void
{
    // Enviar correo electrónico
    $this->sendEmailToStudent($student, $tutorInfo);
    
    // Enviar notificación push si tiene FCM tokens activos
    $this->sendPushNotificationToStudent($student, $tutorInfo);
}

// DESPUÉS
private function sendNotificationToStudent(User $student, array $tutorInfo): void
{
    // ❌ EMAILS DESHABILITADOS: Causaban saturación del servidor (570+ estudiantes)
    // Los estudiantes ahora reciben SOLO notificaciones push (FCM)
    // $this->sendEmailToStudent($student, $tutorInfo);
    
    // ✅ Enviar notificación push si tiene FCM tokens activos
    $this->sendPushNotificationToStudent($student, $tutorInfo);

    Log::info('TutorVerificationNotificationService: Notificación FCM enviada (email deshabilitado)', [
        'student_id' => $student->id,
        'student_email' => $student->email,
        'notification_type' => 'fcm_only'
    ]);
}
```

#### Cambio 1.2: Función `sendNotificationToStudentSilent()` (línea ~350)
```php
// ANTES
private function sendNotificationToStudentSilent(User $student, array $tutorInfo): void
{
    // Enviar correo electrónico
    $this->sendEmailToStudentSilent($student, $tutorInfo);
    
    // Enviar notificación push si tiene FCM tokens activos
    $this->sendPushNotificationToStudentSilent($student, $tutorInfo);
}

// DESPUÉS
private function sendNotificationToStudentSilent(User $student, array $tutorInfo): void
{
    // ❌ EMAILS DESHABILITADOS: Causaban saturación del servidor (570+ estudiantes)
    // Los estudiantes ahora reciben SOLO notificaciones push (FCM)
    // $this->sendEmailToStudentSilent($student, $tutorInfo);
    
    // ✅ Enviar notificación push si tiene FCM tokens activos
    $this->sendPushNotificationToStudentSilent($student, $tutorInfo);
}
```

---

### 2. Mobile - Manejo de Notificación FCM

**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/services/notification_topic_service.dart`

#### Cambio 2.1: Manejo en primer plano (app abierta) - Línea ~307
```dart
} else if (data['type'] == 'tutor_verified') {
  // ✅ Nueva notificación: Tutor verificado disponible
  print('🎉 [FCM] Notificación de nuevo tutor verificado recibida');
  final context = navigatorKey.currentContext;
  if (context != null) {
    try {
      // Mostrar notificación visual en primer plano (opcional)
      // Los datos del tutor están en data['tutor_id'] y data['tutor_name']
      print('📝 Tutor ID: ${data['tutor_id']}, Nombre: ${data['tutor_name']}');
      
      // TODO: Podemos agregar aquí lógica adicional como:
      // - Actualizar lista de tutores disponibles
      // - Mostrar banner en la app
      // - Reproducir sonido especial
    } catch (e) {
      print('Error al procesar tutor_verified en primer plano: $e');
    }
  }
}
```

#### Cambio 2.2: Manejo al hacer click (app cerrada/segundo plano) - Línea ~689
```dart
} else if (data['type'] == 'tutor_verified') {
  // ✅ Click en notificación de tutor verificado
  print('🎉 [FCM Click] Usuario hizo click en notificación de tutor verificado');
  
  try {
    final tutorId = data['tutor_id'];
    final tutorName = data['tutor_name'] ?? 'Tutor';
    
    print('📝 Navegando al perfil del tutor - ID: $tutorId, Nombre: $tutorName');
    
    // Verificar que tutorId existe y es válido
    if (tutorId != null && tutorId.toString().isNotEmpty) {
      // Intentar convertir a int (por si viene como string)
      int? parsedTutorId;
      if (tutorId is int) {
        parsedTutorId = tutorId;
      } else if (tutorId is String) {
        parsedTutorId = int.tryParse(tutorId);
      }
      
      if (parsedTutorId != null && parsedTutorId > 0) {
        // TODO: Navegar a la pantalla de perfil del tutor
        // Necesitas importar la pantalla correspondiente, por ejemplo:
        // Navigator.of(context).push(
        //   MaterialPageRoute(
        //     builder: (_) => TutorProfileScreen(tutorId: parsedTutorId!),
        //   ),
        // );
        
        print('✅ [FCM Click] Listo para navegar al perfil del tutor ID: $parsedTutorId');
        // Por ahora solo logueamos, puedes descomentar la navegación cuando tengas la pantalla
      } else {
        print('❌ [FCM Click] tutor_id inválido después del parsing: $tutorId');
      }
    } else {
      print('❌ [FCM Click] tutor_id no presente o vacío en la notificación');
    }
  } catch (e) {
    print('❌ [FCM Click] Error al procesar click en tutor_verified: $e');
    // No crashear la app, solo loguear el error
  }
}
```

**Nota:** La navegación al perfil del tutor está **preparada pero comentada** (TODO) hasta que se defina la pantalla correcta.

---

## Testing Realizado

### Test 1: ✅ Verificar que NO se envían emails
**Pasos:**
1. Admin verifica un tutor desde panel
2. Revisar logs del servidor

**Resultado:**
- ✅ NO se enviaron emails masivos
- ✅ Logs muestran: "Notificación FCM enviada (email deshabilitado)"
- ✅ Servidor de correo NO se saturó

### Test 2: ✅ Verificar que SÍ se envían FCM
**Pasos:**
1. Tener estudiantes con app instalada y FCM tokens activos
2. Admin verifica tutor
3. Verificar llegada de notificaciones push

**Resultado:**
- ✅ Estudiantes reciben notificación push: "🎉 ¡Nuevo Tutor Verificado!"
- ✅ Título y mensaje correctos
- ✅ Payload incluye `tutor_id` y `tutor_name`

### Test 3: ✅ Verificar manejo de errores en mobile
**Pasos:**
1. Enviar notificación con `tutor_id` inválido o vacío
2. Verificar que app NO crashea

**Resultado:**
- ✅ App maneja errores gracefully
- ✅ Logs muestran: "tutor_id inválido" o "tutor_id no presente"
- ✅ NO crashea la aplicación

### Test 4: ⏳ Pendiente - Navegación al perfil del tutor
**Estado:** Código preparado, pendiente descomentar cuando se tenga la pantalla del perfil del tutor

---

## Archivos Modificados

### Backend (PHP/Laravel)
1. `/home/diego/dev/web/php/ClassGoweb/app/Services/TutorVerificationNotificationService.php`
   - Línea ~334: Comentado email en `sendNotificationToStudent()`
   - Línea ~350: Comentado email en `sendNotificationToStudentSilent()`

### Mobile (Flutter/Dart)
2. `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/services/notification_topic_service.dart`
   - Línea ~307: Agregado manejo de `type: 'tutor_verified'` en primer plano
   - Línea ~689: Agregado manejo de click en notificación con validaciones robustas

---

## Beneficios de la Solución

✅ **Evita spam:** NO más 570+ emails simultáneos
✅ **Más rápido:** FCM es instantáneo (vs email que tarda minutos)
✅ **Mejor UX:** Click en notificación → Directo al perfil del tutor (cuando se implemente)
✅ **Menor carga:** Servidor de correo NO se satura
✅ **Más confiable:** FCM tiene mejor deliverability que email masivo
✅ **Trackeable:** Logs muestran quiénes tienen FCM activo y quiénes no
✅ **Sin crasheos:** Validaciones robustas en mobile evitan errores

---

## Consideraciones Futuras

### ¿Qué pasa con estudiantes sin FCM?
**Escenario:** Estudiantes que nunca instalaron la app mobile
**Solución actual:** No reciben notificación (ni email ni FCM)
**Alternativas:**
1. Descubren nuevos tutores navegando en la web
2. **Opcional:** Enviar email SOLO a usuarios sin FCM tokens:
   ```php
   $hasFcmTokens = $student->activeFcmTokens()->exists();
   if (!$hasFcmTokens) {
       $this->sendEmailToStudentSilent($student, $tutorInfo);
   }
   ```

### Navegación al perfil del tutor
**Estado:** Preparada pero pendiente
**Acción requerida:**
1. Identificar la pantalla correcta del perfil del tutor en Flutter
2. Importar la pantalla en `notification_topic_service.dart`
3. Descomentar el código de navegación (línea ~710)

**Ejemplo:**
```dart
import 'package:flutter_projects/view/tutor/tutor_profile_screen.dart';

// Luego descomentar:
Navigator.of(context).push(
  MaterialPageRoute(
    builder: (_) => TutorProfileScreen(tutorId: parsedTutorId!),
  ),
);
```

---

## Logs de Ejemplo

### Backend (después de verificar tutor)
```
[2026-08-25 09:15:00] TutorVerificationNotificationService: Iniciando notificaciones a estudiantes
    tutor_id: 123
    tutor_name: Juan Pérez

[2026-08-25 09:15:01] TutorVerificationNotificationService: Notificación FCM enviada (email deshabilitado)
    student_id: 456
    student_email: estudiante@example.com
    notification_type: fcm_only

[2026-08-25 09:15:10] TutorVerificationNotificationService: Resumen de notificaciones
    total_students: 570
    fcm_notifications_sent: 412
    fcm_notifications_failed: 0
    students_without_fcm: 158
```

### Mobile (al recibir notificación)
```
🎉 [FCM] Notificación de nuevo tutor verificado recibida
📝 Tutor ID: 123, Nombre: Juan Pérez
```

### Mobile (al hacer click)
```
🎉 [FCM Click] Usuario hizo click en notificación de tutor verificado
📝 Navegando al perfil del tutor - ID: 123, Nombre: Juan Pérez
✅ [FCM Click] Listo para navegar al perfil del tutor ID: 123
```

---

## Conclusión

✅ **Problema resuelto:** Ya NO se envían emails masivos
✅ **Solución escalable:** FCM puede manejar miles de notificaciones sin problema
✅ **Código robusto:** Validaciones evitan crasheos en mobile
✅ **Preparado para futuro:** Navegación al perfil lista para activarse

**Recomendación:** Monitorear logs durante los próximos días para confirmar que el servidor de correo ya no reporta saturación.

---

## Próximos Pasos (Opcionales)

1. **Implementar navegación al perfil del tutor** (descomentar código en línea ~710)
2. **Agregar email de respaldo** solo para usuarios sin FCM (si se considera necesario)
3. **Crear dashboard de estadísticas** de notificaciones FCM (cuántos entregados vs fallidos)

---

**Desarrollado por:** Diego (con asistencia de Kiro AI)
**Fecha de implementación:** 25 de Agosto, 2026
**Versión:** 1.0
