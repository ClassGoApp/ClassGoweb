# 🚀 Cómo Ejecutar los Scripts SQL - Verificación de Identidad

## 📋 Resumen Rápido

Se han creado **2 archivos SQL** listos para ejecutar:

1. **`SQL_TEST_RÁPIDO.sql`** ← **EJECUTA ESTO PRIMERO**
2. **`SCRIPTS_SQL_TUTORES_VERIFICACION.sql`** ← Luego este

---

## ⚠️ PROBLEMA QUE SE SOLUCIONÓ

**Error anterior:** `#1054 - No se reconoce la columna 'u.name' en SELECT`

**Causas:**
- La tabla `users` no tiene columna `name` (fue eliminada)
- La tabla `users` no tiene columna `role` (está en tabla `roles` separada)

**Solución:**
- Nombre: `CONCAT(p.first_name, ' ', p.last_name)` (desde tabla `profiles`)
- Rol: JOIN con tablas `model_has_roles` y `roles`

---

## 🧪 PASO 1: Ejecuta el Test Rápido

### Qué hace:
Verifica que tu base de datos tenga la estructura correcta antes de correr los scripts principales.

### Cómo hacerlo:

**Opción A: PhpMyAdmin**
1. Abre PhpMyAdmin
2. Selecciona tu base de datos `ClassGo`
3. Haz clic en "SQL"
4. Copia TODO el contenido de `SQL_TEST_RÁPIDO.sql`
5. Pega en el editor SQL
6. Haz clic en "Ejecutar"

**Opción B: Terminal/CLI**
```bash
cd /home/diego/dev/web/php/ClassGoweb
mysql -u usuario -p classgo_db < SQL_TEST_RÁPIDO.sql
```

### Qué deberías ver:
```
┌─────────────────────────┬───────┐
│ test                    │ total │
├─────────────────────────┼───────┤
│ TABLA USERS             │ 145   │
│ TABLA PROFILES          │ 145   │
│ TABLA ROLES             │ 3     │
│ TABLA MODEL_HAS_ROLES   │ 200   │
│ TABLA USER_IDENTITY_... │ 45    │
└─────────────────────────┴───────┘

Total de TUTORES: 95
Tutores CON verificación: 32
Tutores SIN verificación: 63
```

**Si ves errores aquí → STOP, no continúes. Contacta soporte.**

---

## ✅ PASO 2: Ejecuta los Scripts Principales

Una vez que el test rápido funciona, ejecuta los scripts de verificación:

### Opción A: PhpMyAdmin (RECOMENDADO)
1. Abre PhpMyAdmin
2. Selecciona tu base de datos `ClassGo`
3. Haz clic en "SQL"
4. Copia TODO el contenido de `SCRIPTS_SQL_TUTORES_VERIFICACION.sql`
5. Pega en el editor SQL
6. Haz clic en "Ejecutar"

### Opción B: Terminal/CLI
```bash
cd /home/diego/dev/web/php/ClassGoweb
mysql -u usuario -p classgo_db < SCRIPTS_SQL_TUTORES_VERIFICACION.sql
```

---

## 📊 SCRIPTS DISPONIBLES (dentro del archivo principal)

### **SCRIPT 1: Tutores CON verificación**
- Muestra: Tutores que YA subieron documentos
- Útil para: Ver quiénes completaron la verificación
- Resultado: Lista de tutores + estado de aprobación
- **NUEVO:** Con numeración (1, 2, 3...) para fácil referencia

### **SCRIPT 2: Tutores SIN verificación**
- Muestra: Tutores que NUNCA subieron documentos
- Útil para: **Contactarlos y recordarles que verifiquen**
- Resultado: Lista de emails para contactar
- **NUEVO:** Con numeración ordenada por antigüedad

### **SCRIPT 3: RESUMEN GENERAL (el más útil)**
- Muestra: TODOS los tutores con su estado
- Útil para: Ver el panorama general en una tabla
- Resultado: Estado completo de cada tutor (sin envío / incompleto / completo / aprobado)
- **NUEVO:** Con numeración - los más urgentes primero (1, 2, 3...)

### **SCRIPT 4: Exportar para Contactar**
- Muestra: Emails de tutores que necesitan completar
- Útil para: Copiar a un CSV o gestor de emails
- Resultado: Email + Nombre + Estado (para enviar recordatorios)
- **NUEVO:** Con numeración para seguimiento

### **SCRIPT 5: Estadísticas**
- Muestra: Contar tutores por estado
- Útil para: Ver el resumen (ej: 20% completado, 50% no enviado)
- Resultado: Tabla con cantidad y porcentaje
- Nota: Sin numeración (agrupa por estado)

### **SCRIPT 6: Ver Detalles de 1 Tutor**
- Muestra: Todo sobre un tutor específico
- Útil para: Investigar un caso en particular
- Cómo: Cambia `123` por el ID del tutor
- Numeración: Siempre "1" (un solo resultado)

### **SCRIPT 7: Documentos Incompletos**
- Muestra: Qué documentos faltan (frontal o trasera)
- Útil para: Contactarlos de forma más específica
- Resultado: Tutor + qué le falta
- **NUEVO:** Con numeración para seguimiento

---

## 🎯 RECOMENDACIÓN: ORDEN DE USO

### Para obtener visión general:
1. **Script 3** (resumen general) → ¿Cuántos faltan?
2. **Script 5** (estadísticas) → ¿Porcentaje por estado?

### Para contactar tutores:
1. **Script 4** (exportar para contactar) → Obtén emails
2. **Copia emails a tu gestor de emails**
3. **Envía recordatorio** (ver plantilla abajo)

### Para investigar casos:
1. **Script 6** (detalles de 1 tutor) → Cambia el ID
2. **Script 7** (incompletos) → Qué falta

---

## 📧 PLANTILLA DE EMAIL PARA CONTACTAR

Copia esta plantilla y personaliza:

```
Asunto: Completa tu verificación de identidad en ClassGo 🆔

Hola [NOMBRE],

Para acceder a ClassGo y comenzar a enseñar, necesitas verificar tu identidad.

⏰ Tómate 2 minutos para:
- Subir foto frontal de tu carnet de identidad
- Subir foto trasera de tu carnet de identidad
- Subir foto personal tuya

➡️ [LINK A TU APP O PANEL]

Una vez completado, revisaremos tu solicitud en 24 horas.

❓ ¿Necesitas ayuda? 
Responde a este email o contacta a nuestro equipo de soporte.

Saludos,
Equipo ClassGo
```

---

## ⚠️ ESTRUCTURA DE DATOS (IMPORTANTE)

Para entender los resultados:

```
users (tabla principal)
├── id (ID del usuario)
├── email (correo)
├── created_at (fecha registro)
├── email_verified_at (email verificado)
│
└─► model_has_roles (relación de roles)
    └─► roles (tabla de roles)
        └── name = 'tutor' o 'student'

users (tabla principal)
├── id
│
└─► profiles (tabla de perfil)
    ├── first_name (nombre)
    └── last_name (apellido)

users (tabla principal)
├── id
│
└─► user_identity_verifications (verificación de identidad)
    ├── status (0=pendiente, 1=aprobado, 2=rechazado)
    ├── attachments (JSON con {"front":"...", "back":"..."})
    ├── personal_photo (foto personal)
    └── created_at (cuando se subió)
```

---

## ❌ ERRORES COMUNES

### Error: "No se reconoce la columna 'u.role'"
**Causa:** El script que ejecutaste es de una versión anterior
**Solución:** Asegúrate de usar `SCRIPTS_SQL_TUTORES_VERIFICACION.sql` (actualizado)

### Error: "Table 'model_has_roles' doesn't exist"
**Causa:** Probablemente uses una BD sin Spatie permissions
**Solución:** Contacta soporte para verificar tu instalación

### Error: "No results"
**Causa:** No hay tutores registrados aún
**Solución:** Es normal si acabas de crear la BD. Registra algunos tutores primero.

---

## ✔️ CHECKLIST

- [ ] He ejecutado `SQL_TEST_RÁPIDO.sql`
- [ ] El test rápido funcionó sin errores
- [ ] He ejecutado `SCRIPTS_SQL_TUTORES_VERIFICACION.sql`
- [ ] Vi resultados del Script 3 (resumen general) **con numeración (nro 1, 2, 3...)**
- [ ] Identifiqué cuántos tutores faltan verificarse
- [ ] Exporté emails con Script 4 (con numeración para seguimiento)
- [ ] Estoy listo para contactar tutores

---

## 🆕 NUEVA CARACTERÍSTICA: Numeración

Todos los scripts ahora incluyen una columna `nro` (numeración) para fácil referencia:

```
nro | ID_Tutor | Nombre | Estado
1   | 45       | Juan   | NO ENVIADO
2   | 67       | María  | INCOMPLETO
3   | 89       | Carlos | COMPLETO
```

Ver ejemplo completo en `EJEMPLO_RESULTADOS_CON_NRO.md`

---

## 📞 PRÓXIMO PASO

Una vez que tengas los datos:

1. **¿Necesitas agregar esto al panel admin?**
   - Tengo código PHP listo (ver `TUTORES_VERIFICACION_IDENTIDAD_GUIA.md`)

2. **¿Necesitas automatizar recordatorios?**
   - Puedo crear un comando Laravel que envíe emails

3. **¿Necesitas integrar validaciones?**
   - Puedo bloquear tutores que no verifiquen

---

## 📎 ARCHIVOS GENERADOS

En `/home/diego/dev/web/php/ClassGoweb/`:

```
✅ SQL_TEST_RÁPIDO.sql
✅ SCRIPTS_SQL_TUTORES_VERIFICACION.sql
✅ TUTORES_VERIFICACION_IDENTIDAD_GUIA.md
✅ INSTRUCCIONES_EJECUTAR_SCRIPTS.md (este archivo)
```

Todos están listos para usar. ¡Adelante! 🚀
