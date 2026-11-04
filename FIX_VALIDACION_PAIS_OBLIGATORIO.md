# FIX: Validación de País Obligatorio - Step Two Onboarding

## Fecha: 25 de Agosto, 2026

---

## Problema Identificado

**Síntoma:**
El usuario podía hacer click en "Siguiente" en Step Two sin seleccionar un país, avanzando al Step Three. Al finalizar el onboarding y enviar los datos, el backend rechazaba con error SQL porque el campo `country_id` es obligatorio.

**Causa Raíz:**
1. En `step_two_personal.dart`, cuando `_selectedCountryId` era `null` (sin selección), se sincronizaba con el provider usando `countryId: _selectedCountryId ?? 0`
2. Esto hacía que el provider siempre tuviera `selectedCountryId = 0` en lugar de `null`
3. La validación en `onboarding_screen.dart` solo verificaba `if (selectedCountryId == null)`, entonces `0` pasaba la validación
4. El getter `isStepTwoValid` tampoco validaba `selectedCountryId == 0`
5. Al llegar al envío final, el backend recibía `country_id = 0` (inválido) y rechazaba con error SQL

---

## Solución Implementada

### Cambio 1: Provider - Hacer `countryId` nullable y validar `0`

**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/provider/onboarding_provider.dart`

#### 1.1 Getter `isStepTwoValid` - Validar que no sea `0`
```dart
// Antes
bool get isStepTwoValid =>
    dateOfBirth != null &&
    selectedCountryId != null &&
    gender != null &&
    profilePhoto != null &&
    (!countryHasStates || selectedStateId != null);

// Después
bool get isStepTwoValid =>
    dateOfBirth != null &&
    selectedCountryId != null &&
    selectedCountryId != 0 &&  // ← Validación agregada
    gender != null &&
    profilePhoto != null &&
    (!countryHasStates || selectedStateId != null);
```

#### 1.2 Función `updatePersonalData` - Hacer `countryId` nullable
```dart
// Antes
void updatePersonalData({
  required DateTime dob,
  required int countryId,  // ← Era required
  // ...
}) {
  dateOfBirth = dob;
  selectedCountryId = countryId;  // ← Siempre se asignaba (incluso 0)
  // ...
}

// Después
void updatePersonalData({
  required DateTime dob,
  int? countryId,  // ← Ahora es nullable
  // ...
}) {
  dateOfBirth = dob;
  if (countryId != null && countryId != 0) {  // ← Solo asigna si es válido
    selectedCountryId = countryId;
  }
  // ...
}
```

#### 1.3 Función `submitFullOnboarding` - Validar antes de enviar
```dart
// Antes
if (selectedCountryId == null || gender == null || profilePhoto == null ||
    (countryHasStates && selectedStateId == null) ||
    personalPhoto == null || documentFile == null) {
  // ...
}

// Después
if (selectedCountryId == null || selectedCountryId == 0 ||  // ← Validación agregada
    gender == null || profilePhoto == null ||
    (countryHasStates && selectedStateId == null) ||
    personalPhoto == null || documentFile == null) {
  // ...
}
```

---

### Cambio 2: Screen - Validar `selectedCountryId == 0` en botón "Siguiente"

**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/onboarding_screen.dart`

```dart
// Antes
if (freshProvider.selectedCountryId == null) {
  CustomToast.show(context, "Selecciona tu país", isSuccess: false);
  return;
}

// Después
if (freshProvider.selectedCountryId == null || freshProvider.selectedCountryId == 0) {
  CustomToast.show(context, "Selecciona tu país", isSuccess: false);
  return;
}
```

---

### Cambio 3: Widget Step Two - Pasar `null` en lugar de `0`

**Archivo:** `/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/widgets/step_two_personal.dart`

```dart
// Antes
void _syncWithProvider() {
  context.read<OnboardingProvider>().updatePersonalData(
    dob: _selectedDob ?? DateTime(2000),
    countryId: _selectedCountryId ?? 0,  // ← Enviaba 0 cuando era null
    // ...
  );
}

// Después
void _syncWithProvider() {
  context.read<OnboardingProvider>().updatePersonalData(
    dob: _selectedDob ?? DateTime(2000),
    countryId: _selectedCountryId,  // ← Ahora envía null cuando no hay selección
    // ...
  );
}
```

---

## Flujo de Validación Corregido

### Escenario 1: Usuario no selecciona país

1. **Inicio:** `_selectedCountryId = null` (local)
2. **Sync con provider:** `selectedCountryId = null` (provider - no se asigna `0`)
3. **Click en "Siguiente":**
   - ✅ Validación: `selectedCountryId == null || selectedCountryId == 0`
   - ✅ Resultado: Muestra Custom Toast **"Selecciona tu país"**
   - ✅ **No avanza** al siguiente paso

### Escenario 2: Usuario selecciona país sin estados (ej. Chile)

1. **Selección:** `_selectedCountryId = 45` (ID de Chile)
2. **Sync con provider:** `selectedCountryId = 45`
3. **API no retorna estados:** `countryHasStates = false`
4. **Click en "Siguiente":**
   - ✅ Validación: `selectedCountryId != null && selectedCountryId != 0` → ✅ Pasa
   - ✅ Validación: `!countryHasStates || selectedStateId != null` → ✅ Pasa (no tiene estados)
   - ✅ **Avanza** al siguiente paso

### Escenario 3: Usuario selecciona país con estados (ej. Bolivia)

1. **Selección:** `_selectedCountryId = 30` (ID de Bolivia)
2. **Sync con provider:** `selectedCountryId = 30`
3. **API retorna estados:** `countryHasStates = true`
4. **Click en "Siguiente" SIN seleccionar departamento:**
   - ✅ Validación: `selectedCountryId != null && selectedCountryId != 0` → ✅ Pasa
   - ❌ Validación: `countryHasStates && selectedStateId == null` → ❌ Falla
   - ✅ Resultado: Muestra Custom Toast **"Selecciona tu departamento"**
   - ✅ **No avanza** hasta que seleccione departamento

### Escenario 4: Usuario completa correctamente (Bolivia + La Paz)

1. **Selección país:** `selectedCountryId = 30`
2. **Selección estado:** `selectedStateId = 123` (La Paz)
3. **Click en "Siguiente":**
   - ✅ Todas las validaciones pasan
   - ✅ **Avanza** al siguiente paso
4. **Al finalizar y enviar:**
   - ✅ Backend recibe `country_id = 30`, `state_id = 123`
   - ✅ **Se guarda correctamente** en la base de datos

---

## Archivos Modificados

1. **`/home/diego/dev/mobile/flutter/ClassGoMobil/lib/provider/onboarding_provider.dart`**
   - Línea ~47: Agregada validación `selectedCountryId != 0` en `isStepTwoValid`
   - Línea ~76: Agregada validación `selectedCountryId == 0` en `submitFullOnboarding`
   - Línea ~164: Cambiado `countryId` de `required int` a `int?` en `updatePersonalData`
   - Línea ~171: Agregada condición `if (countryId != null && countryId != 0)` antes de asignar

2. **`/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/onboarding_screen.dart`**
   - Línea ~104: Agregada validación `|| freshProvider.selectedCountryId == 0` en `_nextPage()`

3. **`/home/diego/dev/mobile/flutter/ClassGoMobil/lib/view/tutor/onboarding/widgets/step_two_personal.dart`**
   - Línea ~70: Eliminado `?? 0`, ahora pasa `null` directamente cuando no hay selección

---

## Testing Recomendado

### Test 1: Sin seleccionar país
**Pasos:**
1. Abrir onboarding
2. Completar Step 1
3. En Step 2, NO seleccionar país (dejar dropdown vacío)
4. Completar fecha de nacimiento, género y foto de perfil
5. Click en "Siguiente"

**Resultado esperado:**
- ❌ No avanza
- ✅ Aparece Custom Toast: **"Selecciona tu país"**

---

### Test 2: Seleccionar país sin estados
**Pasos:**
1. Completar Step 1
2. En Step 2, seleccionar un país SIN estados (ej. Chile)
3. Completar otros campos (fecha, género, foto)
4. Click en "Siguiente"

**Resultado esperado:**
- ✅ Avanza a Step 3 sin problemas
- ✅ NO aparece campo de departamento (porque Chile no tiene)

---

### Test 3: Seleccionar país con estados, sin seleccionar departamento
**Pasos:**
1. Completar Step 1
2. En Step 2, seleccionar Bolivia
3. Esperar a que carguen los departamentos
4. NO seleccionar ningún departamento
5. Completar otros campos
6. Click en "Siguiente"

**Resultado esperado:**
- ❌ No avanza
- ✅ Aparece Custom Toast: **"Selecciona tu departamento"**

---

### Test 4: Flujo completo correcto
**Pasos:**
1. Completar Step 1 (Materias)
2. Completar Step 2:
   - Fecha de nacimiento: Cualquiera
   - País: Bolivia
   - Departamento: La Paz
   - Género: Masculino
   - Foto de perfil: Subir imagen
3. Avanzar a Step 3
4. Subir documentos (foto personal, carnet frente y reverso)
5. Click en "Finalizar"

**Resultado esperado:**
- ✅ Avanza sin problemas en todos los pasos
- ✅ Envía datos correctamente al backend
- ✅ Backend guarda con `country_id` y `state_id` válidos
- ✅ **NO hay error SQL**
- ✅ Muestra mensaje: "¡Tus datos han sido enviados para verificación!"

---

### Test 5: Verificar en Base de Datos
**SQL Query:**
```sql
SELECT 
    uiv.id,
    uiv.user_id,
    uiv.name,
    uiv.dob,
    a.country_id,
    c.name as country_name,
    a.state_id,
    s.name as state_name,
    uiv.created_at
FROM user_identity_verifications uiv
INNER JOIN addresses a ON uiv.id = a.user_identity_verification_id
LEFT JOIN countries c ON a.country_id = c.id
LEFT JOIN states s ON a.state_id = s.id
WHERE uiv.user_id = {USER_ID}
ORDER BY uiv.created_at DESC
LIMIT 1;
```

**Resultado esperado:**
- ✅ `country_id` tiene un valor válido (NO es `0` ni `NULL`)
- ✅ `state_id` tiene valor si el país tiene estados, o es `NULL`/`0` si no tiene
- ✅ `country_name` y `state_name` se resuelven correctamente

---

## Conclusión

✅ **Validación triple implementada:**
1. Provider getter `isStepTwoValid` valida `!= null && != 0`
2. Botón "Siguiente" valida `== null || == 0` con Custom Toast
3. Función `submitFullOnboarding` valida antes de enviar al backend

✅ **Flujo de datos corregido:**
- Widget → `_selectedCountryId` (nullable)
- Sync → `countryId` (nullable en función)
- Provider → `selectedCountryId` (solo asigna si válido)

✅ **Prevención de error SQL:**
- Backend ya NO recibirá `country_id = 0`
- Usuario NO puede avanzar sin seleccionar país válido

✅ **UX mejorada:**
- Mensajes claros con Custom Toast
- Validación en cada punto del flujo
- Feedback inmediato al usuario

**Próximo paso:** Compilar y probar en dispositivo/emulador con los 5 tests descritos.
