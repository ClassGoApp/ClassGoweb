# 📋 Análisis Completo: Tutores sin Verificación vs Verificados

**Fecha:** Septiembre 2, 2026  
**Base de Datos:** `classgo` (MySQL)  
**Usuario:** Admin / Diego

---

## 📊 Resumen Ejecutivo

Este documento contiene un análisis estructura de la base de datos de ClassGo enfocado en:
1. **Tutores SIN verificación de identidad** (lista limpia con correo + teléfono)
2. **Tutores CON verificación de identidad** (lista limpia con correo + teléfono)
3. **Detección de perfiles duplicados**
4. **Consolidación de información duplicada**

---

## 🔍 Estructura de Datos - Entendimiento

### **¿Cómo se identifican los Tutores?**

```
users (tabla base)
    ↓
model_has_roles (tabla relacional N:M)
    ↓
roles (donde roles.name = 'tutor')
    ↓
profiles (información personal: nombre, teléfono, descripción)
    ↓
user_identity_verifications (documentos: frente, reverso, estado)
```

**Punto clave:** Un tutor es un usuario que tiene una **fila en `model_has_roles`** con `role.name = 'tutor'`.

### **Campos de Contacto Disponibles**

| Tabla | Campo | Tipo | Significado |
|-------|-------|------|-------------|
| `profiles` | `phone_number` | string(20) | ✅ **TELÉFONO PRINCIPAL** del tutor |
| `users` | `email` | string | ✅ **CORREO ÚNICO** del tutor |
| `user_identity_verifications` | `parent_phone` | string | Teléfono del padre (si es menor de edad) |
| `user_contacts` | `detail` | string | Contactos alternativos (whatsapp, telegram, etc) |

**Observación importante:** El campo `phone_number` se agregó recientemente (noviembre 2024), así que tutores antiguos pueden tenerlo vacío.

---

## ✅ SCRIPT 8: Tutores SIN Verificación (Lista Limpia)

### **¿Quiénes están aquí?**
Tutores que:
- Nunca enviaron documentos de identidad, O
- Enviaron documentos pero están incompletos (falta frente o reverso), O
- Enviaron documentos pero fueron rechazados

### **¿Qué información incluye?**
- `nro` → Número de fila (para referencia)
- `ID_Tutor` → ID único en la BD
- `CORREO` → Email del tutor (campo único en `users`)
- `TELÉFONO` → Número de teléfono de `profiles.phone_number`
- `NOMBRE_COMPLETO` → Nombre completo (first_name + last_name)
- `FECHA_REGISTRO` → Cuándo se registró en la plataforma
- `DÍAS_DESDE_REGISTRO` → Cuántos días han pasado desde el registro
- `ESTADO_VERIFICACIÓN` → Razón específica del estado pendiente:
  - "Nunca enviaron documentos"
  - "Enviaron pero incompletos"
  - "Falta foto frontal"
  - "Falta foto trasera"
- `EMAIL_VERIFICADO` → Si el email está confirmado

### **Cómo usar este script:**

```sql
-- Ejecuta este script para obtener tutores sin verificación
-- Cópia y pega en tu cliente MySQL/Adminer
-- Puedes exportar el resultado a CSV desde tu herramienta
```

**Casos de uso:**
- 📧 Enviar emails recordatorios automáticos
- 📱 Contactar por teléfono a tutores sin documentos
- 📊 Generar reportes de auditoría
- 🎯 Crear campañas de seguimiento

---

## ✅ SCRIPT 9: Tutores CON Verificación (Lista Limpia)

### **¿Quiénes están aquí?**
Tutores que:
- Enviaron AMBOS documentos (frente + reverso)
- Documentos están completos

### **Estados de Verificación**

| Estado | Símbolo | Significado |
|--------|---------|------------|
| **Aprobado** | ✅ | Identidad verificada, tutor activo |
| **En Revisión** | ⏳ | Documentos recibidos, esperando aprobación de admin |
| **Rechazado** | ❌ | Documentos no válidos, necesita resubir |

### **¿Qué información incluye?**
- `nro` → Número de fila
- `ID_Tutor` → ID único
- `CORREO` → Email del tutor
- `TELÉFONO` → Número de teléfono
- `NOMBRE_COMPLETO` → Nombre completo
- `FECHA_REGISTRO` → Cuándo se registró
- `FECHA_ENVÍO_IDENTIDAD` → Cuándo envió documentos
- `DÍAS_DESDE_ENVÍO` → Cuántos días hace que envió
- `ESTADO_VERIFICACIÓN` → ✅ Aprobado / ⏳ En Revisión / ❌ Rechazado
- `EMAIL_VERIFICADO` → Si confirmó email

### **Cómo usar este script:**

```sql
-- Este script muestra TODOS los tutores con documentos completos
-- Útil para:
-- - Ver tutores con verificación COMPLETA
-- - Revisar estado de aprobación
-- - Filtrar solo los APROBADOS (estado = '✅ APROBADO')
```

**Casos de uso:**
- 🎯 Identificar tutores activos y verificados
- ⏳ Ver pendientes de aprobación final
- 📋 Auditoría de identidad verificada
- 🚀 Listar tutores listos para tutoría

---

## 🔎 SCRIPT 10: Detectar Perfiles DUPLICADOS

### **¿Por qué duplicados?**
Posibles causas:
1. Usuario se registró 2+ veces sin saber
2. Migración de datos incompleta
3. Sincronización fallida entre sistemas
4. Error manual en base de datos
5. Múltiples métodos de login (Google, Facebook, manual) → múltiples cuentas

### **A. Duplicados por EMAIL** (Lo más probable)
```sql
-- Busca múltiples tutores con el MISMO EMAIL
-- SELECT ... WHERE email IN (SELECT email FROM users GROUP BY email HAVING COUNT(*) > 1)
```

**Resultado:** 
- `CANTIDAD_PERFILES` → Cuántos perfiles comparten este email
- `IDS_TUTORES` → IDs de cada perfil (ej: 123,456,789)
- `NOMBRES` → Nombres en cada perfil (puede variar si usó nicknames)
- `TELÉFONOS` → Teléfonos en cada perfil

**Decisión a tomar:**
- Conservar perfil más antiguo (primer registro)
- Transferir datos importantes del perfil nuevo al antiguo
- Eliminar perfil duplicado

### **B. Duplicados por NOMBRE COMPLETO**
```sql
-- Busca tutores con MISMO NOMBRE pero DIFERENTE EMAIL
-- Puede ser persona legítima con 2 cuentas
-- O múltiples personas con mismo nombre
```

**Validación manual necesaria:**
- Comparar teléfonos
- Comparar emails
- Revisar fechas de registro
- Contactar tutor para confirmar

### **C. Duplicados por TELÉFONO**
```sql
-- Busca tutores con MISMO TELÉFONO
-- Fuerte indicador de duplicación
```

**Decisión a tomar:**
- Si email es diferente → posible error de data entry
- Si email es igual → claramente duplicado
- Contactar tutor para confirmar

---

## 🔗 SCRIPT 11: Consolidar Información de Duplicados

### **¿Cuándo usar?**
Cuando encontraste duplicados en Scripts 10 y necesitas tomar decisión de merge.

### **Información que te muestra:**

Para cada EMAIL DUPLICADO, muestra:
- `DUPLICADO_NUM` → 1, 2, 3... (orden de antigüedad)
- `CORREO_DUPLICADO` → Email compartido
- `ID_TUTOR` → ID de cada cuenta
- `NOMBRE_COMPLETO` → Nombre en cada perfil
- `TELÉFONO` → Teléfono en cada perfil
- `ESTADO_USUARIO` → 1=activo, 0=inactivo
- `FECHA_REGISTRO` → Cuándo se registró
- `EMAIL_VERIFICADO_EN` → Si verificó email
- `VERIFICACIÓN_IDENTIDAD` → Estado de documentos
- `FECHA_ENVÍO_IDENTIDAD` → Cuándo envió documentos
- `ROL_EN_SISTEMA` → Si es tutor activo
- `TOTAL_IDENTIDADES_DUPLICADAS` → Cuántos duplicados hay

### **Cómo leer los resultados:**

```
Email: diego@example.com (encontramos 2 duplicados)

DUPLICADO_NUM=1 (más antiguo)
  ├─ ID: 101
  ├─ Nombre: Diego González
  ├─ Teléfono: +591234567890
  ├─ Registro: 2024-01-15
  ├─ Email verificado: Sí
  ├─ Identidad: ✅ Aprobado
  ├─ Rol: Tutor activo
  └─ Recomendación: MANTENER ESTE (es el principal)

DUPLICADO_NUM=2 (más reciente)
  ├─ ID: 456
  ├─ Nombre: D. Gonzalez (variante)
  ├─ Teléfono: NULL (vacío)
  ├─ Registro: 2024-09-20
  ├─ Email verificado: No
  ├─ Identidad: No enviaron
  ├─ Rol: Tutor activo
  └─ Recomendación: ELIMINAR (datos incompletos)
```

---

## 🛠️ Pasos Recomendados de Limpieza

### **Fase 1: Análisis (SIN cambios)**

```sql
-- 1. Ejecuta SCRIPT 10 (Detectar duplicados)
-- Lee los resultados cuidadosamente
-- Guarda resultados en CSV o screenshot para referencia

-- 2. Para cada email duplicado, ejecuta SCRIPT 11
-- Identifica cuál es el perfil "real" y cuáles son duplicados
```

### **Fase 2: Decisión**

Para cada grupo de duplicados, decide:
- ✅ **MANTENER:** El perfil más antiguo, más completo, verificado
- ❌ **ELIMINAR:** El perfil duplicado, incompleto, o sin verificación

**Criterios de decisión:**
1. ¿Cuál tiene email verificado?
2. ¿Cuál tiene identidad aprobada?
3. ¿Cuál tiene teléfono?
4. ¿Cuál tiene más datos completos?
5. ¿Cuál es más antiguo (primer registro)?

### **Fase 3: Consolidación (requiere scripts adicionales)**

```sql
-- ADVERTENCIA: Estos scripts son DESTRUCTIVOS
-- Haz BACKUP antes de ejecutar

-- Opción A: Marcar como inactivo (no eliminar)
UPDATE users SET status = 0 WHERE id = 456;

-- Opción B: Soft delete (mantiene datos, solo marca eliminado)
UPDATE profiles SET deleted_at = NOW() WHERE user_id = 456;

-- Opción C: Transferir datos y luego eliminar
-- (Requiere lógica personalizada según tu caso)
```

---

## 📊 Estadísticas Útiles

### **Script para contar estado general:**

```sql
SELECT 
    CASE 
        WHEN uiv.id IS NULL THEN 'SIN DOCUMENTOS'
        WHEN uiv.attachments IS NULL THEN 'DOCUMENTOS INCOMPLETOS'
        WHEN uiv.status = 0 THEN 'EN REVISIÓN'
        WHEN uiv.status = 1 THEN 'APROBADO'
        WHEN uiv.status = 2 THEN 'RECHAZADO'
    END as 'CATEGORÍA',
    COUNT(u.id) as 'CANTIDAD_TUTORES',
    ROUND(COUNT(u.id) * 100 / (
        SELECT COUNT(DISTINCT u2.id)
        FROM users u2
        INNER JOIN model_has_roles mhr2 ON u2.id = mhr2.model_id
        INNER JOIN roles r2 ON mhr2.role_id = r2.id
        WHERE r2.name = 'tutor'
    ), 2) as 'PORCENTAJE'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
GROUP BY 
    CASE 
        WHEN uiv.id IS NULL THEN 'SIN DOCUMENTOS'
        WHEN uiv.attachments IS NULL THEN 'DOCUMENTOS INCOMPLETOS'
        WHEN uiv.status = 0 THEN 'EN REVISIÓN'
        WHEN uiv.status = 1 THEN 'APROBADO'
        WHEN uiv.status = 2 THEN 'RECHAZADO'
    END;
```

---

## 🚀 Campos de Contacto - Lo que Necesitas Saber

### **Campo PRINCIPAL para contactar tutores:**

| Prioridad | Campo | Tabla | Disponibilidad | Uso |
|-----------|-------|-------|----------------|-----|
| 1️⃣ | `email` | `users` | 100% (requerido) | Contacto oficial, verificable |
| 2️⃣ | `phone_number` | `profiles` | ~70% (agregado reciente) | Contacto directo por SMS/WhatsApp |
| 3️⃣ | `parent_phone` | `user_identity_verifications` | ~10% (menores edad) | Contacto de padre/tutor legal |
| 4️⃣ | `detail` (user_contacts) | `user_contacts` | ~5% | Contactos alternativos |

### **¿Por qué algunos tutores no tienen teléfono?**

1. **El campo es nuevo** (agregado en Nov 2024)
   - Tutores registrados antes = no tienen phone_number
   - Solución: Contactar por email

2. **No completaron perfil** 
   - Se registraron pero no llenaron datos completos
   - Solución: Enviar email pidiendo que completen

3. **Datos incompletos durante migración**
   - Si vinieron de otro sistema, teléfono puede no haber migrado
   - Solución: Pedir que actualicen en plataforma

### **Recomendación:**

**Para asegurar tener TODOS los teléfonos:**

```sql
-- Tutores sin teléfono en profiles
SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as nombre,
    p.phone_number,
    uiv.parent_phone
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND (p.phone_number IS NULL OR p.phone_number = '')
ORDER BY u.created_at DESC;

-- Acción: Enviar email pidiendo que completen teléfono en su perfil
```

---

## ❓ Preguntas Frecuentes

### **P: ¿Cuál es la diferencia entre "SIN DOCUMENTOS" y "DOCUMENTOS INCOMPLETOS"?**

**SIN DOCUMENTOS:** 
- Nunca subieron NADA a la BD
- `user_identity_verifications.id` es NULL
- Nunca hicieron clic en "Verificar identidad"

**DOCUMENTOS INCOMPLETOS:**
- Subieron pero falta foto o frente o reverso
- `user_identity_verifications.id` existe
- Pero `attachments.front` O `attachments.back` es NULL

### **P: ¿Cómo elimino un perfil duplicado?**

**NUNCA hagas DELETE directo.** Opciones seguras:

1. **Marcar como inactivo:**
   ```sql
   UPDATE users SET status = 0 WHERE id = 456;
   ```

2. **Soft delete del perfil:**
   ```sql
   UPDATE profiles SET deleted_at = NOW() WHERE user_id = 456;
   ```

3. **Remover rol de tutor:**
   ```sql
   DELETE FROM model_has_roles 
   WHERE model_id = 456 
     AND role_id = (SELECT id FROM roles WHERE name = 'tutor');
   ```

4. **Para eliminación completa:** Primero transfiere datos importante, luego usa soft delete

### **P: ¿Cómo confirmo que dos perfiles son de la MISMA persona?**

**Criterios más seguros (en orden de confianza):**

1. ✅ Mismo email + diferente teléfono = **probablemente SÍ**
2. ✅ Mismo teléfono + diferente email = **probablemente SÍ**
3. ⚠️ Mismo nombre exacto = **necesita validar**
4. ⚠️ Nombre similar = **necesita validar manualmente**

**Validación recomendada:**
```sql
-- Para cada par sospechoso, compara:
SELECT 
    u.id,
    u.email,
    p.phone_number,
    CONCAT(p.first_name, ' ', p.last_name) as nombre_completo,
    u.created_at,
    uiv.name as documento_identidad,
    uiv.status as identity_status
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.id IN (101, 456);  -- Reemplaza con IDs a comparar
```

### **P: ¿Los duplicados afectan el funcionamiento de la plataforma?**

**SÍ, puede causar problemas:**

1. 📧 Duplicar emails de confirmación
2. 💬 Confundir historial de mensajes
3. ⭐ Dividir reseñas entre 2 perfiles
4. 💰 Problemas con pagos/presupuesto
5. 📊 Estadísticas incorrectas

**Acción urgente:** Eliminar duplicados ASAP

---

## 🔒 Procedimiento de Seguridad

### **ANTES de cualquier limpieza:**

1. ✅ **Haz BACKUP de la BD completa**
   ```bash
   mysqldump -u usuario -p classgo > backup_$(date +%Y%m%d).sql
   ```

2. ✅ **Prueba en ambiente de DESARROLLO primero**
   - Copia los scripts en BD test
   - Verifica resultados

3. ✅ **Revisa 2-3 veces antes de eliminar**
   - Si dudas, contacta al tutor
   - Mejor perder tiempo que perder datos

4. ✅ **Documenta cada cambio**
   - Quién, cuándo, por qué
   - Log de cambios

---

## 📝 Resumen de Scripts Nuevos

| Script | Función | Datos | Uso Recomendado |
|--------|---------|-------|-----------------|
| **SCRIPT 8** | Tutores SIN verificación | Email + Teléfono | Contactos para seguimiento |
| **SCRIPT 9** | Tutores CON verificación | Email + Teléfono | Audit de tutores verificados |
| **SCRIPT 10** | Detectar duplicados | Emails/nombres/teléfonos | Análisis de duplicación |
| **SCRIPT 11** | Consolidar duplicados | Todos los datos del duplicado | Decidir qué perfil mantener |

---

## ✨ Próximos Pasos

1. **Ejecuta SCRIPT 8** → Genera lista tutores SIN verificación
2. **Ejecuta SCRIPT 9** → Genera lista tutores CON verificación
3. **Ejecuta SCRIPT 10** → Detecta si hay duplicados
4. **Ejecuta SCRIPT 11** (si hay duplicados) → Consolida información
5. **Contacta tutores sin verificación** → Email + teléfono de SCRIPT 8
6. **Limpia duplicados** → Según procedimiento de seguridad

---

**Preguntas? Revisa el archivo SCRIPTS_SQL_TUTORES_VERIFICACION.sql para todos los scripts listos para ejecutar.**

