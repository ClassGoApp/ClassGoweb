# ⚡ INICIO RÁPIDO - Tutores & Verificación

**Si tienes 5 minutos:** Lee esto  
**Si tienes 30 minutos:** Ejecuta los scripts  
**Si necesitas detalles:** Abre otros documentos

---

## 🎯 Antes: ¿Qué Necesitas?

Acceso a herramienta SQL:
- ✅ Adminer (web, más fácil) → `http://localhost:8080`
- ✅ DBeaver (desktop, más poderosa)
- ✅ Terminal MySQL (avanzado)

---

## 📊 Los 4 Scripts Nuevos

### **SCRIPT 8 - Tutores SIN Verificación**

```
¿Para qué? → Contactar tutores que no verificaron
Qué da? → Email + Teléfono + Estado
Acción → Email/SMS recordatorio
```

**Copia-pega esto en tu herramienta SQL:**

```sql
SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    p.phone_number as 'TELÉFONO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    u.created_at as 'FECHA_REGISTRO',
    DATEDIFF(NOW(), u.created_at) as 'DÍAS_DESDE_REGISTRO',
    CASE 
        WHEN uiv.id IS NULL THEN 'Nunca enviaron documentos'
        WHEN uiv.attachments IS NULL THEN 'Enviaron pero incompletos'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NULL THEN 'Falta foto frontal'
        WHEN JSON_EXTRACT(uiv.attachments, '$.back') IS NULL THEN 'Falta foto trasera'
        ELSE 'Incompleto (desconocido)'
    END as 'ESTADO_VERIFICACIÓN',
    CASE 
        WHEN u.email_verified_at IS NOT NULL THEN 'Sí'
        ELSE 'No'
    END as 'EMAIL_VERIFICADO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND (
        uiv.id IS NULL 
        OR uiv.attachments IS NULL
        OR JSON_EXTRACT(uiv.attachments, '$.front') IS NULL
        OR JSON_EXTRACT(uiv.attachments, '$.back') IS NULL
    )
ORDER BY u.created_at DESC;
```

---

### **SCRIPT 9 - Tutores CON Verificación**

```
¿Para qué? → Ver tutores con documentos completos
Qué da? → Email + Teléfono + Estado (Aprobado/En revisión/Rechazado)
Acción → Revisar estado, auditoría
```

**Copia-pega esto:**

```sql
SELECT 
    ROW_NUMBER() OVER (
        ORDER BY 
            CASE WHEN uiv.status = 1 THEN 0 ELSE 1 END,
            u.created_at DESC
    ) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    p.phone_number as 'TELÉFONO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    u.created_at as 'FECHA_REGISTRO',
    uiv.created_at as 'FECHA_ENVÍO_IDENTIDAD',
    DATEDIFF(NOW(), uiv.created_at) as 'DÍAS_DESDE_ENVÍO',
    CASE 
        WHEN uiv.status = 1 THEN '✅ APROBADO'
        WHEN uiv.status = 0 THEN '⏳ EN REVISIÓN'
        WHEN uiv.status = 2 THEN '❌ RECHAZADO'
        ELSE 'Desconocido'
    END as 'ESTADO_VERIFICACIÓN',
    CASE 
        WHEN u.email_verified_at IS NOT NULL THEN 'Sí'
        ELSE 'No'
    END as 'EMAIL_VERIFICADO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.attachments IS NOT NULL
    AND JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL
    AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL
ORDER BY 
    CASE WHEN uiv.status = 1 THEN 0 ELSE 1 END,
    u.created_at DESC;
```

---

### **SCRIPT 10 - Detectar Duplicados**

```
¿Para qué? → Encontrar perfiles duplicados
Qué da? → Emails/nombres/teléfonos que se repiten
Acción → Tomar decisión de qué mantener/eliminar
```

**Copia-pega esto (OPCIÓN A - Por EMAIL):**

```sql
SELECT 
    u.email,
    COUNT(u.id) as 'CANTIDAD_PERFILES',
    GROUP_CONCAT(u.id) as 'IDS_TUTORES',
    GROUP_CONCAT(CONCAT(p.first_name, ' ', p.last_name)) as 'NOMBRES',
    GROUP_CONCAT(p.phone_number) as 'TELÉFONOS'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
WHERE r.name = 'tutor'
GROUP BY u.email
HAVING COUNT(u.id) > 1
ORDER BY COUNT(u.id) DESC;
```

**Resultado = Duplicados encontrados** ✅

---

### **SCRIPT 11 - Consolidar Duplicados**

```
¿Para qué? → Ver TODOS los datos de duplicados
Qué da? → Información completa para decidir qué eliminar
Acción → Decidir: mantener ID 101, eliminar ID 456
```

**Copia-pega esto:**

```sql
SELECT 
    ROW_NUMBER() OVER (PARTITION BY u.email ORDER BY u.created_at ASC) as 'DUPLICADO_NUM',
    u.email as 'CORREO_DUPLICADO',
    u.id as 'ID_TUTOR',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    p.phone_number as 'TELÉFONO',
    u.status as 'ESTADO_USUARIO',
    u.created_at as 'FECHA_REGISTRO',
    u.email_verified_at as 'EMAIL_VERIFICADO_EN',
    CASE 
        WHEN uiv.id IS NULL THEN 'No enviaron'
        WHEN uiv.attachments IS NULL THEN 'Enviaron incompleto'
        WHEN uiv.status = 1 THEN '✅ Aprobado'
        WHEN uiv.status = 0 THEN '⏳ En revisión'
        WHEN uiv.status = 2 THEN '❌ Rechazado'
        ELSE 'Desconocido'
    END as 'VERIFICACIÓN_IDENTIDAD',
    COALESCE(uiv.created_at, '—') as 'FECHA_ENVÍO_IDENTIDAD',
    CASE 
        WHEN mhr.model_id IS NOT NULL THEN 'Tutor activo'
        ELSE 'Sin rol tutor'
    END as 'ROL_EN_SISTEMA',
    COUNT(uiv.id) OVER (PARTITION BY u.email) as 'TOTAL_IDENTIDADES_DUPLICADAS'
FROM users u
LEFT JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
LEFT JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND u.email IN (
        SELECT u2.email
        FROM users u2
        INNER JOIN model_has_roles mhr2 ON u2.id = mhr2.model_id AND mhr2.model_type = 'App\\Models\\User'
        INNER JOIN roles r2 ON mhr2.role_id = r2.id
        WHERE r2.name = 'tutor'
        GROUP BY u2.email
        HAVING COUNT(u2.id) > 1
    )
ORDER BY u.email, u.created_at ASC;
```

---

## 🚀 Pasos en 5 Minutos

**1. Abre Adminer o DBeaver**

```
Adminer: http://localhost:8080
DBeaver: Aplicación de escritorio
```

**2. Conecta a BD `classgo`**

**3. Ejecuta SCRIPT 8**

```
Copia el SELECT del SCRIPT 8 de arriba
Pega en tu herramienta
Click "Execute" o presiona Ctrl+Enter
```

**4. Revisa resultados**

```
¿Hay tutores sin verificar?
¿Cuántos?
¿Tienen teléfono?
```

**5. Exporta a Excel (opcional)**

```
Adminer: Click "Export" → CSV
DBeaver: Click derecho → Export → Excel
```

---

## 📁 Documentos Completos

| Documento | Tamaño | Propósito |
|-----------|--------|----------|
| **SCRIPTS_SQL_TUTORES_VERIFICACION.sql** | 19KB | Todos los 11 scripts, listo para ejecutar |
| **ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md** | 16KB | Análisis técnico profundo de BD |
| **GUIA_EJECUCION_SCRIPTS_TUTORES.md** | 13KB | Paso a paso para ejecutar cada script |
| **RESUMEN_EJECUTIVO_TUTORES.md** | 12KB | Resumen visual y toma de decisiones |
| **INICIO_RAPIDO_TUTORES.md** | Este | Versión "copiar-pega rápido" |

---

## ❓ FAQ Rápido

**P: ¿Cuál es el campo de teléfono?**  
R: `profiles.phone_number` (puede ser NULL en tutores antiguos)

**P: ¿Email y teléfono son únicos?**  
R: Email SÍ (único en `users`). Teléfono NO (puede repetirse)

**P: ¿Hay duplicados en la BD?**  
R: Ejecuta SCRIPT 10, te lo dice al instante

**P: ¿Cómo veo si un tutor está verificado?**  
R: SCRIPT 9 → busca estado "✅ APROBADO"

**P: ¿Qué es INCOMPLETO?**  
R: Subió pero falta frente o reverso. SCRIPT 8 te lo dice.

**P: ¿Puedo eliminar duplicados?**  
R: SÍ pero con cuidado. Ver ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md sección "Seguridad"

---

## 🎯 Próximo Paso

**Abre tu herramienta SQL (Adminer o DBeaver) y ejecuta SCRIPT 8 AHORA**

Resultado: Lista de tutores sin verificar con correo + teléfono

¡Listo! 🚀

---

**Versión:** 1.0  
**Fecha:** Septiembre 2, 2026

