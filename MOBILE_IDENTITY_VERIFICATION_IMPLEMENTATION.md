# Mobile Identity Verification - Two-Sided ID Card Implementation

## Resumen de Cambios

Se implementó la captura de **ambas caras del carnet de identidad** (frente y reverso) en la app mobile para tutores, replicando la lógica existente de Livewire (web) en el API backend.

---

## Cambios Realizados

### Backend (PHP/Laravel)

#### 1. **IdentityStoreRequest.php** - Validación
**Archivo:** `/home/diego/dev/web/php/ClassGoweb/app/Http/Requests/Common/Identity/IdentityStoreRequest.php`

**Cambios:**
- Para **tutores**: Validar `identificationCardFront` (required) e `identificationCardBack` (required)
- Para **estudiantes**: Mantiene validación de `transcript` (sin cambios)
- Ambos campos usan las mismas reglas: `required|mimes:{ext}|max:{size}`

```php
// Antes
$key = auth()->user()->role == 'tutor' ? 'identificationCard' : 'transcript';
$rules[$key] = $imageValidation;

// Después
if (auth()->user()->role == 'tutor') {
    $rules['identificationCardFront'] = $imageValidation;
    $rules['identificationCardBack'] = $imageValidation;
} else {
    $rules['transcript'] = $imageValidation;
}
```

---

#### 2. **IdentityController.php** - Procesamiento y almacenamiento
**Archivo:** `/home/diego/dev/web/php/ClassGoweb/app/Http/Controllers/Api/IdentityController.php`

**Cambios:**
- Importado `Illuminate\Support\Str` para usar `Str::slug()`
- Para **tutores**: Procesar ambas fotos y guardar como JSON
- Patrón de nombres: `{nombre-slug}-id-front-{timestamp}.ext` y `{nombre-slug}-id-back-{timestamp}.ext`
- Formato JSON almacenado: `{"front":"identity_photo/archivo-front.jpg","back":"identity_photo/archivo-back.jpg"}`

```php
// Tutores: procesar ambas caras del carnet
$attachmentsArray = [];
$cleanName = Str::slug(trim($request->name));

// Foto FRONTAL
if ($request->hasFile('identificationCardFront')) {
    $extension = $request->identificationCardFront->getClientOriginalExtension();
    $filenameFront = $cleanName . '-id-front-' . time() . '.' . $extension;
    // ... mover archivo ...
    $attachmentsArray['front'] = 'identity_photo/' . $filenameFront;
}

// Foto TRASERA
if ($request->hasFile('identificationCardBack')) {
    $extension = $request->identificationCardBack->getClientOriginalExtension();
    $filenameBack = $cleanName . '-id-back-' . time() . '.' . $extension;
    // ... mover archivo ...
    $attachmentsArray['back'] = 'identity_photo/' . $filenameBack;
}

// Guardar como JSON
$verificationData['attachments'] = json_encode($attachmentsArray);
```

---

### Mobile (Flutter/Dart)

#### 3. **step_three_docs.dart** - UI de captura
**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/widgets/step_three_docs.dart`

**Cambios:**
- Agregada variable `File? _documentFileBack` para foto trasera
- Actualizada función `_pickImage` con parámetro opcional `isBack`
- Actualizada función `_showPickerOptions` con parámetro opcional `isBack`
- Agregado segundo widget `_buildUploadBox` para "Carnet de Identidad (Reverso)" (solo visible para tutores)
- Ambos cuadros mantienen el mismo tamaño: `height: 180`

```dart
// Variables de estado
File? _documentFile;       // Foto frontal
File? _documentFileBack;   // Foto trasera

// Segundo cuadro (solo para tutores)
if (widget.role == 'tutor') ...[
  const SizedBox(height: 24),
  _buildUploadBox(
    title: 'Carnet de Identidad (Reverso)',
    icon: Icons.badge_rounded,
    imageFile: _documentFileBack,
    onTap: () => _showPickerOptions(context, false, isBack: true),
    isCircle: false,
  ),
],
```

---

#### 4. **onboarding_provider.dart** - Estado y lógica
**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/provider/onboarding_provider.dart`

**Cambios:**
- Agregada variable `File? documentFileBack`
- Actualizado `updateDocuments` para aceptar `docFileBack`
- Actualizado `submitFullOnboarding` para:
  - Validar que foto trasera sea obligatoria para tutores
  - Pasar ambos archivos a `submitIdentityVerification`
  - Cambiar firma de función: `documentKey/document` → `role/documentFront/documentBack`
- Actualizado `clearData` para limpiar `documentFileBack`

```dart
// Validación adicional para tutores
if (role == 'tutor' && documentFileBack == null) {
  return {'success': false, 'message': 'Debes subir ambas caras del carnet.'};
}

// Llamada al API
final identityResponse = await submitIdentityVerification(
  token: token,
  role: role,
  documentFront: documentFile!,
  documentBack: documentFileBack,  // null para estudiantes
  // ... otros parámetros ...
);
```

---

#### 5. **api_service.dart** - Envío al backend
**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/api_structure/api_service.dart` (línea ~1250)

**Cambios:**
- Eliminado parámetro `required String documentKey` (era dinámico)
- Agregados parámetros:
  - `required String role`
  - `required File documentFront`
  - `File? documentBack` (nullable para estudiantes)
- Para **tutores**: enviar con claves fijas `identificationCardFront` e `identificationCardBack`
- Para **estudiantes**: enviar con clave `transcript`

```dart
Future<Map<String, dynamic>> submitIdentityVerification({
  required String token,
  required String role,           // ← Nuevo
  required File documentFront,    // ← Nuevo (antes era "document")
  File? documentBack,             // ← Nuevo (nullable)
  // ... otros parámetros ...
}) async {
  if (role == 'tutor') {
    request.files.add(await http.MultipartFile.fromPath(
        'identificationCardFront', documentFront.path));
    
    if (documentBack != null) {
      request.files.add(await http.MultipartFile.fromPath(
          'identificationCardBack', documentBack.path));
    }
  } else {
    request.files.add(await http.MultipartFile.fromPath(
        'transcript', documentFront.path));
  }
}
```

---

## Verificación de No Duplicación

✅ **Se reutilizaron funciones existentes:**
- `uniqueFileName()` de `app/Helpers/helpers.php` (línea 238) - NO se duplicó
- `Str::slug()` de Laravel - NO se creó función custom
- `json_encode()` nativo de PHP - NO se creó función custom

✅ **Se siguió el mismo patrón que Livewire:**
- Nombres de archivo: `{nombre-slug}-id-front/back-{timestamp}.ext`
- Formato JSON: `{"front":"ruta1","back":"ruta2"}`
- Validaciones idénticas

---

## Plan de Testing

### 1. Testing Backend (PHP/Laravel)

#### Test 1.1: Validación de Request
**Objetivo:** Verificar que el API rechaza requests incompletos

**Pasos:**
1. Enviar POST a `/api/identity-verification` como tutor sin `identificationCardBack`
2. Enviar POST sin `identificationCardFront`
3. Enviar POST con archivos no válidos (PDF, TXT, etc.)
4. Enviar POST con archivos mayores a 5MB

**Resultado esperado:**
- HTTP 422 (Unprocessable Entity)
- Mensaje de error indicando campo faltante o inválido

#### Test 1.2: Procesamiento y Almacenamiento
**Objetivo:** Verificar que ambas fotos se guardan correctamente

**Pasos:**
1. Enviar POST válido con ambas fotos del carnet
2. Verificar en base de datos:
   - Tabla `user_identity_verifications`
   - Campo `attachments` debe contener JSON: `{"front":"...","back":"..."}`
3. Verificar en filesystem:
   - Archivos existen en `public/storage/identity_photo/`
   - Nombres siguen patrón: `nombre-slug-id-front-123456.jpg` y `nombre-slug-id-back-123456.jpg`

**Resultado esperado:**
- HTTP 200
- JSON guardado correctamente en BD
- Archivos físicos creados con nombres correctos

**SQL para verificar:**
```sql
SELECT id, user_id, name, attachments 
FROM user_identity_verifications 
WHERE user_id = {ID_TUTOR}
ORDER BY created_at DESC 
LIMIT 1;
```

#### Test 1.3: Compatibilidad con Estudiantes
**Objetivo:** Verificar que el flujo de estudiantes sigue funcionando

**Pasos:**
1. Enviar POST a `/api/identity-verification` como estudiante con `transcript`
2. Verificar que NO se requiere `identificationCardBack`

**Resultado esperado:**
- HTTP 200
- Campo `transcript` guardado correctamente (string simple, no JSON)

---

### 2. Testing Mobile (Flutter)

#### Test 2.1: UI - Captura de Fotos
**Objetivo:** Verificar que la UI muestra ambos cuadros correctamente

**Pasos:**
1. Abrir onboarding como tutor
2. Navegar a Step 3 (Documentos)
3. Verificar que aparecen 3 cuadros:
   - "Foto Personal"
   - "Carnet de Identidad (Frente)"
   - "Carnet de Identidad (Reverso)"
4. Todos los cuadros deben tener el mismo tamaño y estilo
5. Capturar foto frontal desde cámara
6. Capturar foto trasera desde galería
7. Verificar que ambas se muestran correctamente

**Resultado esperado:**
- Ambos cuadros visibles y con mismo diseño
- Fotos capturadas se muestran en sus respectivos cuadros
- Borde verde cuando hay foto capturada

#### Test 2.2: Validación de Campos Obligatorios
**Objetivo:** Verificar que no se puede continuar sin ambas fotos

**Pasos:**
1. Capturar solo foto frontal (sin trasera)
2. Intentar continuar al siguiente paso
3. Capturar solo foto trasera (sin frontal)
4. Intentar continuar

**Resultado esperado:**
- Toast/mensaje de error: "Debes subir ambas caras del carnet de identidad"
- No permite avanzar hasta que ambas estén presentes

#### Test 2.3: Flujo Completo - Estudiante
**Objetivo:** Verificar que estudiantes no ven el cuadro de foto trasera

**Pasos:**
1. Abrir onboarding como estudiante
2. Navegar a Step 3 (Documentos)
3. Verificar que solo aparecen 2 cuadros:
   - "Foto Personal"
   - "Historial Académico / Matrícula"
4. Completar onboarding

**Resultado esperado:**
- Solo 2 cuadros visibles
- No se requiere foto trasera
- Onboarding completo exitosamente

---

### 3. Testing End-to-End

#### Test 3.1: Flujo Completo - Tutor (Mobile → Backend → BD)
**Objetivo:** Verificar el flujo completo desde mobile hasta base de datos

**Pasos:**
1. Crear cuenta de tutor en mobile
2. Completar Step 1 (Materias)
3. Completar Step 2 (Datos personales)
4. Completar Step 3:
   - Subir foto personal
   - Subir foto frontal del carnet
   - Subir foto trasera del carnet
5. Enviar formulario
6. Verificar en backend:
   - Registro creado en `user_identity_verifications`
   - Campo `attachments` contiene JSON válido
   - Archivos físicos existen en `storage/identity_photo/`
7. Verificar nombres de archivo:
   - Patrón: `{nombre}-id-front-{timestamp}.jpg`
   - Patrón: `{nombre}-id-back-{timestamp}.jpg`

**Resultado esperado:**
- Toast de éxito: "Perfil completado con éxito"
- Datos guardados correctamente en BD
- JSON en columna `attachments`: `{"front":"identity_photo/...","back":"identity_photo/..."}`
- Archivos físicos existen y son accesibles

**SQL para verificar:**
```sql
-- Ver último registro del tutor
SELECT u.id, u.email, uiv.name, uiv.attachments, uiv.personal_photo, uiv.created_at
FROM users u
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.email = 'tutor-test@example.com'
ORDER BY uiv.created_at DESC
LIMIT 1;

-- Decodificar JSON (MySQL)
SELECT 
    JSON_EXTRACT(attachments, '$.front') as foto_frontal,
    JSON_EXTRACT(attachments, '$.back') as foto_trasera
FROM user_identity_verifications
WHERE user_id = {ID_TUTOR};
```

#### Test 3.2: Comparación con Web (Livewire)
**Objetivo:** Verificar que ambos flujos generan el mismo resultado

**Pasos:**
1. Completar verificación de identidad desde **web** (Livewire)
2. Completar verificación de identidad desde **mobile** (Flutter)
3. Comparar registros en base de datos

**Resultado esperado:**
- Ambos registros tienen formato JSON idéntico en columna `attachments`
- Patrón de nombres de archivo es consistente
- Estructura de directorios es la misma

---

### 4. Testing de Regresión

#### Test 4.1: Livewire sigue funcionando
**Objetivo:** Verificar que cambios en API no rompieron el flujo web

**Pasos:**
1. Iniciar sesión como tutor en web
2. Ir a "Configuración → Verificación de Identidad"
3. Subir foto personal
4. Subir foto frontal del carnet
5. Subir foto trasera del carnet
6. Enviar formulario

**Resultado esperado:**
- Formulario se envía correctamente
- Datos se guardan sin errores
- Flujo funciona exactamente igual que antes

#### Test 4.2: API Students (sin cambios)
**Objetivo:** Verificar que el flujo de estudiantes no se afectó

**Pasos:**
1. Enviar POST a `/api/identity-verification` como estudiante
2. Solo enviar `transcript` (sin fotos de carnet)

**Resultado esperado:**
- HTTP 200
- Registro guardado correctamente
- Campo `transcript` guardado como string (no JSON)

---

## Checklist de Validación Final

Antes de considerar la implementación completa, verificar:

- [ ] Backend valida ambos campos (`identificationCardFront` e `identificationCardBack`) para tutores
- [ ] Backend guarda JSON en formato: `{"front":"...","back":"..."}`
- [ ] Archivos físicos se crean con nombres correctos: `{nombre}-id-front-{timestamp}.ext`
- [ ] Mobile muestra dos cuadros del mismo tamaño para frente y reverso
- [ ] Mobile valida que ambas fotos estén presentes antes de enviar
- [ ] Mobile envía archivos con claves fijas: `identificationCardFront` e `identificationCardBack`
- [ ] Flujo de estudiantes sigue funcionando (transcript)
- [ ] Livewire (web) sigue funcionando sin cambios
- [ ] No se duplicaron funciones existentes (`uniqueFileName`, `Str::slug`, `json_encode`)
- [ ] Formato JSON es idéntico entre web y mobile

---

## Archivos Modificados

### Backend (5 archivos)
1. `/home/diego/dev/web/php/ClassGoweb/app/Http/Requests/Common/Identity/IdentityStoreRequest.php`
2. `/home/diego/dev/web/php/ClassGoweb/app/Http/Controllers/Api/IdentityController.php`

### Mobile (3 archivos)
3. `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/widgets/step_three_docs.dart`
4. `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/provider/onboarding_provider.dart`
5. `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/api_structure/api_service.dart`

---

## Notas Técnicas

### Patrón de Nombres de Archivo
```
{nombre-slug}-id-front-{timestamp}.{ext}
{nombre-slug}-id-back-{timestamp}.{ext}

Ejemplo:
juan-perez-id-front-1735156800.jpg
juan-perez-id-back-1735156800.jpg
```

### Formato JSON en Base de Datos
```json
{
  "front": "identity_photo/juan-perez-id-front-1735156800.jpg",
  "back": "identity_photo/juan-perez-id-back-1735156800.jpg"
}
```

### Estructura de Base de Datos
**Tabla:** `user_identity_verifications`
**Columna:** `attachments` (tipo: `JSON` o `TEXT`)

Para tutores: JSON con claves `front` y `back`
Para estudiantes: NULL (usan columna `transcript`)

---

## Troubleshooting

### Problema: "Error al subir documentos"
**Causa:** Uno de los archivos no llegó al backend
**Solución:** Verificar que `documentFileBack` no sea `null` para tutores en `onboarding_provider.dart`

### Problema: Validación falla en backend
**Causa:** Nombres de campos incorrectos en request
**Solución:** Verificar que mobile envía `identificationCardFront` e `identificationCardBack` (no `identificationCard`)

### Problema: JSON no se decodifica correctamente
**Causa:** Formato JSON inválido
**Solución:** Verificar que se usa `json_encode()` y no concatenación de strings

### Problema: Archivos no se crean en filesystem
**Causa:** Permisos de directorio
**Solución:** Verificar que `public/storage/identity_photo` tiene permisos 0775

---

## Fecha de Implementación
**Fecha:** 25 de Agosto, 2026
**Desarrollador:** Diego (con asistencia de Kiro AI)
**Contexto:** Paridad de funcionalidad entre web (Livewire) y mobile (Flutter)
