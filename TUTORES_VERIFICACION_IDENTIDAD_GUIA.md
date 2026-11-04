# Guía Completa: Verificación de Identidad de Tutores

## 📋 Problema Actual

El panel admin solo muestra tutores que verificaron su **email**, pero no muestra el estado de su **verificación de identidad** (carnet de identidad con frente y reverso).

Necesitas saber:
- ✅ Qué tutores YA enviaron verificación de identidad
- ❌ Qué tutores NO han enviado verificación de identidad
- 📧 Sus emails y datos de contacto
- 📲 Para enviarles mensajes recordándoles que verifiquen

---

## 🔍 Entendiendo la Base de Datos

### Tablas Relevantes:
```
users (tabla principal de usuarios)
├── id (ID del tutor)
├── email (email de contacto)
├── name (nombre completo)
├── role (estudiante o tutor)
├── email_verified_at (cuando verificó email)
└── created_at (fecha de registro)

user_identity_verifications (verificaciones de identidad)
├── user_id (vinculado a users.id)
├── attachments (JSON con {"front":"...","back":"..."})
├── status (0=pendiente, 1=aprobado, 2=rechazado)
├── personal_photo (foto del tutor)
└── created_at (cuando subió los documentos)
```

**IMPORTANTE:**
- Si un tutor aparece en `users` pero NO en `user_identity_verifications` → No ha subido documentos
- Si aparece en `user_identity_verifications` pero `attachments` está NULL → No ha completado
- Si `attachments` tiene JSON con "front" y "back" → Completó la verificación

---

## 📊 Scripts SQL - Ejecuta en Producción

### **Script 1: Tutores que SÍ enviaron verificación de identidad**

```sql
SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    uiv.created_at as 'fecha_envio_identidad',
    uiv.status as 'estado_verificacion',
    CASE 
        WHEN uiv.status = 0 THEN 'Pendiente'
        WHEN uiv.status = 1 THEN 'Aprobado'
        WHEN uiv.status = 2 THEN 'Rechazado'
        ELSE 'Desconocido'
    END as 'estado_nombre',
    JSON_EXTRACT(uiv.attachments, '$.front') as 'foto_frontal',
    JSON_EXTRACT(uiv.attachments, '$.back') as 'foto_trasera',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'INCOMPLETO'
    END as 'estado_documentos'
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.role = 'tutor'
ORDER BY uiv.created_at DESC;
```

**Resultado esperado:**
```
id | email              | name           | fecha_registro | fecha_envio | estado_nombre | estado_documentos
1  | juan@email.com     | Juan Pérez     | 2024-01-15     | 2024-02-10  | Pendiente     | COMPLETO
3  | maria@email.com    | María García   | 2024-01-20     | 2024-02-15  | Aprobado      | COMPLETO
```

---

### **Script 2: Tutores que NO enviaron verificación de identidad**

```sql
SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    DATEDIFF(NOW(), u.created_at) as 'dias_desde_registro',
    CASE 
        WHEN u.email_verified_at IS NOT NULL THEN 'SÍ'
        ELSE 'NO'
    END as 'email_verificado'
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
WHERE u.role = 'tutor' 
    AND u.id NOT IN (
        SELECT DISTINCT user_id 
        FROM user_identity_verifications 
        WHERE attachments IS NOT NULL
    )
ORDER BY u.created_at DESC;
```

**Resultado esperado:**
```
id | email            | name         | fecha_registro | dias_desde | email_verificado
2  | pedro@email.com  | Pedro López  | 2024-01-10     | 232        | SÍ
4  | ana@email.com    | Ana Rodríguez| 2024-02-01     | 210        | NO
```

---

### **Script 3: Resumen General (RECOMENDADO - todos en una tabla)**

```sql
SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    CASE 
        WHEN uiv.id IS NULL THEN 'NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN 'INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'ERROR'
    END as 'estado_identidad',
    CASE 
        WHEN uiv.status = 1 THEN 'Aprobado'
        WHEN uiv.status = 2 THEN 'Rechazado'
        WHEN uiv.status = 0 AND uiv.id IS NOT NULL THEN 'En revisión'
        ELSE 'Sin revisar'
    END as 'resultado_verificacion',
    uiv.created_at as 'fecha_ultimo_envio'
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.role = 'tutor'
ORDER BY 
    CASE 
        WHEN uiv.id IS NULL THEN 1  -- Prioridad: sin envío
        WHEN uiv.attachments IS NULL THEN 2  -- Luego: incompletos
        ELSE 3  -- Al final: completos
    END,
    u.created_at DESC;
```

**Resultado esperado - Vista clara:**
```
id | email            | name       | fecha_registro | estado_identidad | resultado_verificacion | fecha_ultimo_envio
2  | pedro@email.com  | Pedro      | 2024-01-10     | NO ENVIADO       | Sin revisar            | NULL
5  | lucia@email.com  | Lucía      | 2024-02-05     | INCOMPLETO       | En revisión            | 2024-02-15
1  | juan@email.com   | Juan       | 2024-01-15     | COMPLETO         | Aprobado               | 2024-02-10
```

---

### **Script 4: Exportar para enviar mensajes (CSV-friendly)**

```sql
SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    CASE 
        WHEN uiv.id IS NULL THEN 'No ha subido documentos'
        WHEN uiv.attachments IS NULL THEN 'Subió documentos incompletos'
        ELSE 'Completó subida'
    END as 'estado'
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.role = 'tutor'
    AND (uiv.id IS NULL OR uiv.attachments IS NULL)
ORDER BY u.created_at DESC;
```

---

## 🎯 Interpretación de Estados

### Estado de Identidad:

| Estado | Significado | Acción |
|--------|-------------|--------|
| **NO ENVIADO** | Tutor no ha subido nada | Enviar recordatorio para subir |
| **INCOMPLETO** | Subió algunos documentos pero faltan (ej: solo frente, sin reverso) | Enviar recordatorio de completar |
| **COMPLETO** | Subió frente y reverso del carnet | Ir a Script 1 para ver verificación |

### Resultado de Verificación:

| Resultado | Significado | Acción |
|-----------|-------------|--------|
| **Sin revisar** | Documentos no subidos | Contactar tutor |
| **En revisión** | Documentos subidos, esperando aprobación | Esperar |
| **Aprobado** | Verificación completada ✅ | Nada, tutor puede acceder |
| **Rechazado** | Documentos fueron rechazados | Contactar tutor para resubir |

---

## 📧 Cómo Enviar Mensajes a Tutores

### Opción A: Usando tu sistema de emails (RECOMENDADO)

1. **Ejecuta el Script 4** para obtener emails
2. **Copia los emails en tu gestor de emails**
3. **Plantilla sugerida:**

```
Asunto: Completa tu verificación de identidad en ClassGo

Hola [NOMBRE],

Para acceder a ClassGo y comenzar a enseñar, necesitas verificar tu identidad 
subiendo ambas caras de tu carnet de identidad.

➡️ [LINK A TU APP O PANEL]

Esto solo toma 2 minutos. Sube:
- Foto frontal del carnet
- Foto reversa del carnet
- Foto personal

Una vez completado, revisaremos tu solicitud en 24 horas.

¿Necesitas ayuda? Responde a este email.

Saludos,
Equipo ClassGo
```

### Opción B: Crear un sistema automático en tu app

Ver sección **"Agregar al Panel Admin"** más abajo.

---

## 🛠️ ¿Deberías Agregar Esto al Panel Admin?

### **SÍ, DEFINITIVAMENTE SÍ**

**Razones:**

1. **Visibilidad:** Necesitas ver quién falta por verificar
2. **Urgencia:** Puedes identificar tutores pendientes por semanas
3. **Automatización:** Puedes enviar recordatorios automáticos
4. **Control:** Puedes ver qué documentos fueron rechazados y por qué
5. **Cumplimiento:** Probablemente sea requisito regulatorio

### **Qué debería mostrar en el panel admin:**

```
╔════════════════════════════════════════════════════════════════╗
║                  TUTORES - VERIFICACIÓN DE IDENTIDAD            ║
╠════════════════════════════════════════════════════════════════╣
║ ID │ Email              │ Nombre        │ Estado      │ Acción  ║
╠════════════════════════════════════════════════════════════════╣
║ 2  │ pedro@email.com    │ Pedro López   │ ❌ NO ENV. │ [👁 VER]║
║ 5  │ lucia@email.com    │ Lucía Rodríg. │ ⚠️ INCOMP. │ [👁 VER]║
║ 1  │ juan@email.com     │ Juan Pérez    │ ✅ COMPLET │ [👁 VER]║
║ 3  │ maria@email.com    │ María García  │ ✅ APROBA. │ [✏️ EDT]║
╚════════════════════════════════════════════════════════════════╝
```

**Columnas:**
- Estado actual (visual + texto)
- Fecha de envío
- Fecha de aprobación
- Botón para ver documentos
- Botón para rechazar/aprobar
- Botón para enviar recordatorio

---

## 💻 Cómo Implementar en el Panel Admin

### Paso 1: Crear migración (si no existe tabla de auditoría)

```php
// database/migrations/2026_08_31_create_identity_verification_tracking.php
Schema::create('identity_verification_actions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->enum('action', ['reminder_sent', 'approved', 'rejected', 'viewed']);
    $table->text('notes')->nullable();
    $table->foreignId('admin_id')->nullable()->constrained('users');
    $table->timestamps();
});
```

### Paso 2: Crear el controlador

```php
// app/Http/Controllers/Admin/IdentityVerificationController.php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserIdentityVerification;
use Illuminate\Http\Request;

class IdentityVerificationController extends Controller
{
    public function index()
    {
        $tutors = User::where('role', 'tutor')
            ->leftJoin('user_identity_verifications', 'users.id', '=', 'user_identity_verifications.user_id')
            ->select([
                'users.id',
                'users.email',
                'users.name',
                'user_identity_verifications.id as verification_id',
                'user_identity_verifications.attachments',
                'user_identity_verifications.status',
                'user_identity_verifications.created_at as verified_at'
            ])
            ->paginate(20);

        return view('admin.identity-verification.index', compact('tutors'));
    }

    public function show($tutorId)
    {
        $verification = UserIdentityVerification::where('user_id', $tutorId)->firstOrFail();
        $attachments = json_decode($verification->attachments, true);
        
        return view('admin.identity-verification.show', compact('verification', 'attachments'));
    }

    public function approve(Request $request, $tutorId)
    {
        $verification = UserIdentityVerification::where('user_id', $tutorId)->firstOrFail();
        $verification->update(['status' => 1]); // 1 = Aprobado

        return redirect()->back()->with('success', 'Tutor verificado correctamente');
    }

    public function reject(Request $request, $tutorId)
    {
        $verification = UserIdentityVerification::where('user_id', $tutorId)->firstOrFail();
        $verification->update(['status' => 2]); // 2 = Rechazado
        
        // Optionalmente, notificar al tutor
        // Notification::send($tutor, new IdentityRejected());

        return redirect()->back()->with('success', 'Verificación rechazada');
    }
}
```

### Paso 3: Crear la vista

```blade
{{-- resources/views/admin/identity-verification/index.blade.php --}}
<div class="container">
    <h2>Verificación de Identidad - Tutores</h2>
    
    {{-- Filtros --}}
    <div class="filters mb-4">
        <button class="btn btn-sm" data-filter="pending">⏳ Pendientes</button>
        <button class="btn btn-sm" data-filter="approved">✅ Aprobados</button>
        <button class="btn btn-sm" data-filter="rejected">❌ Rechazados</button>
    </div>

    {{-- Tabla --}}
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Estado Documentos</th>
                <th>Estado Verificación</th>
                <th>Fecha Envío</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tutors as $tutor)
            <tr>
                <td>{{ $tutor->id }}</td>
                <td>{{ $tutor->email }}</td>
                <td>{{ $tutor->name }}</td>
                <td>
                    @if(is_null($tutor->verification_id))
                        <span class="badge bg-danger">NO ENVIADO</span>
                    @elseif(is_null($tutor->attachments))
                        <span class="badge bg-warning">INCOMPLETO</span>
                    @else
                        <span class="badge bg-success">COMPLETO</span>
                    @endif
                </td>
                <td>
                    @if($tutor->status === 1)
                        <span class="badge bg-success">Aprobado</span>
                    @elseif($tutor->status === 2)
                        <span class="badge bg-danger">Rechazado</span>
                    @else
                        <span class="badge bg-info">En revisión</span>
                    @endif
                </td>
                <td>{{ $tutor->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td>
                    @if(!is_null($tutor->verification_id))
                        <a href="{{ route('admin.identity.show', $tutor->id) }}" class="btn btn-sm btn-info">👁 Ver</a>
                        <form action="{{ route('admin.identity.approve', $tutor->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">✅ Aprobar</button>
                        </form>
                        <form action="{{ route('admin.identity.reject', $tutor->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">❌ Rechazar</button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-warning" onclick="sendReminder({{ $tutor->id }})">📧 Recordatorio</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

### Paso 4: Crear ruta

```php
// routes/admin.php
Route::prefix('admin')->middleware('auth', 'admin')->group(function () {
    Route::resource('identity-verification', \App\Http\Controllers\Admin\IdentityVerificationController::class)
        ->only(['index', 'show']);
    
    Route::post('identity-verification/{id}/approve', [IdentityVerificationController::class, 'approve'])
        ->name('admin.identity.approve');
    
    Route::post('identity-verification/{id}/reject', [IdentityVerificationController::class, 'reject'])
        ->name('admin.identity.reject');
});
```

---

## 📋 Resumen de Acciones Recomendadas

### **Inmediato (Hoy):**
1. ✅ Ejecuta el **Script 3** (resumen general)
2. ✅ Identifica cuántos tutores están pendientes
3. ✅ Ejecuta el **Script 2** para contactarlos

### **Corto plazo (Esta semana):**
1. ✅ Envía recordatorios usando el **Script 4**
2. ✅ Establece un plazo (ej: 7 días para completar)
3. ✅ Documenta quién completó

### **Mediano plazo (Este mes):**
1. ✅ Implementa el panel admin (ver código arriba)
2. ✅ Configura recordatorios automáticos
3. ✅ Establece SLA (Service Level Agreement) con tutores

### **Largo plazo (Este trimestre):**
1. ✅ Integra verificación de identidad como requisito obligatorio
2. ✅ Bloquea acceso si no tiene verificación completa
3. ✅ Implementa notificaciones automáticas

---

## 🔐 Notas de Seguridad

⚠️ **IMPORTANTE:**

1. **No almacenes datos sensibles en caché**
   - Las fotos del carnet contienen datos sensibles
   - Configura headers HTTP para que no se cacheen

2. **Limita acceso al panel admin**
   - Solo admins pueden ver verificaciones
   - Auditoria: registra quién vio qué y cuándo

3. **Protege las fotos**
   - Almacena en directorio no público
   - Requiere autenticación para acceder
   - Considera cifrado

4. **GDPR / Privacidad**
   - Documenta retención de datos
   - Permite que tutores soliciten borrar sus fotos
   - Cumple con regulaciones locales

---

## 📞 Preguntas Frecuentes

**P: ¿Cuánto tiempo tarda la aprobación?**  
R: Depende de ti. Sugiero máximo 24-48 horas.

**P: ¿Qué hago si un tutor sube documentos inválidos?**  
R: Marca como rechazado y envía recordatorio de resubir.

**P: ¿Puedo bloquear tutores que no se verifiquen?**  
R: SÍ - una vez implementado el panel, puedes agregar validación en el modelo User.

**P: ¿Los estudiantes también necesitan verificarse?**  
R: No, solo tutores. Los estudiantes suben "transcript" (matrícula).

**P: ¿Se puede automatizar todo?**  
R: SÍ - pero primero implementa el panel manualmente para entender el flujo.

---

## 📎 Archivos Necesarios

Para implementar todo esto, necesitarás:

```
✅ SCRIPTS SQL (ya tienes, arriba)
✅ MIGRACIÓN (arriba: identity_verification_actions)
✅ CONTROLADOR (arriba: IdentityVerificationController)
✅ VISTA (arriba: index.blade.php)
✅ RUTAS (arriba: routes/admin.php)
```

**Próximo paso:** ¿Quieres que cree los archivos PHP en tu proyecto?

