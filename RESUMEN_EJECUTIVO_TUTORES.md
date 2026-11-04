# 📊 RESUMEN EJECUTIVO - Análisis de Tutores ClassGo

**Fecha:** Septiembre 2, 2026  
**Responsable:** Análisis de BD  
**Base de Datos:** classgo

---

## 🎯 Objetivo

Crear **listas limpias** de tutores SIN y CON verificación de identidad, incluyendo correo y teléfono, identificando y consolidando perfiles duplicados.

---

## ✅ Qué Se Hizo

### **1. Ampliación de Scripts SQL**

Extendimos archivo existente: `SCRIPTS_SQL_TUTORES_VERIFICACION.sql`

**Scripts anteriores (1-7):** Análisis general de verificación  
**Scripts NUEVOS (8-11):** Listas limpias + detección de duplicados

| Script | Nombre | Función | Salida |
|--------|--------|---------|--------|
| **8** | Tutores SIN Verificación | Lista tutores que no enviaron/completaron documentos | CSV con email + teléfono |
| **9** | Tutores CON Verificación | Lista tutores con documentos completos | CSV con email + teléfono + estado |
| **10** | Detectar Duplicados | Busca perfiles duplicados por email/nombre/teléfono | Reportes por criterio |
| **11** | Consolidar Duplicados | Muestra todos los datos de duplicados para tomar decisión | Análisis completo de cada grupo |

---

## 📋 SCRIPT 8: Tutores SIN Verificación

### **¿Para qué sirve?**

Obtener lista de tutores que:
- ❌ Nunca enviaron documentos, O
- ⚠️ Enviaron pero incompletos, O  
- ❌ Fueron rechazados

### **¿Qué información tiene?**

```
nro | ID_Tutor | CORREO | TELÉFONO | NOMBRE_COMPLETO | FECHA_REGISTRO | 
DÍAS_DESDE_REGISTRO | ESTADO_VERIFICACIÓN | EMAIL_VERIFICADO
```

### **Usos Prácticos**

✅ **Contacto masivo** → Enviar recordatorios por email + SMS  
✅ **Seguimiento** → ¿Cuántos llevan meses sin documentos?  
✅ **Auditoría** → ¿Qué % de tutores falta verificar?  
✅ **Conversión** → Identificar tutores a empujar al completar

### **Ejemplo de resultado:**

```
nro | ID_Tutor | CORREO              | TELÉFONO     | NOMBRE_COMPLETO | DÍAS_REGISTRO
1   | 101      | juan@example.com    | 591234567890 | Juan González   | 180
2   | 102      | maria@example.com   | NULL         | María López     | 120
3   | 103      | pedro@example.com   | 591987654321 | Pedro García    | 45
```

---

## 📋 SCRIPT 9: Tutores CON Verificación

### **¿Para qué sirve?**

Obtener lista de tutores con documentos COMPLETOS:
- ✅ Enviaron frente + reverso, O
- ⏳ Están en revisión, O
- ✅ Ya aprobados, O
- ❌ Rechazados (pero completaron intento)

### **¿Qué información tiene?**

```
nro | ID_Tutor | CORREO | TELÉFONO | NOMBRE_COMPLETO | FECHA_REGISTRO |
FECHA_ENVÍO_IDENTIDAD | DÍAS_DESDE_ENVÍO | ESTADO_VERIFICACIÓN | EMAIL_VERIFICADO
```

### **Estados Posibles**

| Estado | Símbolo | Significado |
|--------|---------|------------|
| Aprobado | ✅ | Identidad verificada, puede tutor normalmente |
| En revisión | ⏳ | Recibimos documentos, esperando aprobación admin |
| Rechazado | ❌ | Documentos inválidos, necesita resubir |

### **Usos Prácticos**

✅ **Listar tutores activos** → Solo los ✅ APROBADOS  
✅ **Revisión de documentos** → ¿Cuántos están ⏳ en revisión?  
✅ **Auditoría completa** → Tracking de cada etapa  
✅ **Generar reportes** → Estado de verificación por fecha

### **Ejemplo de resultado:**

```
nro | ID_Tutor | CORREO            | TELÉFONO     | ESTADO_VERIFICACIÓN
1   | 201      | carlos@example... | 591234567890 | ✅ APROBADO
2   | 202      | ana@example.com   | 591987654321 | ⏳ EN REVISIÓN
3   | 203      | luis@example.com  | 591555555555 | ❌ RECHAZADO
```

---

## 🔎 SCRIPT 10: Detectar Duplicados (3 Enfoques)

### **¿Por qué duplicados?**

Causas típicas:
1. 👤 Mismo usuario se registró 2x (olvidó contraseña)
2. 🔄 Migración incompleta
3. 🔐 Múltiples OAuth (Google + Facebook + manual)
4. 🐛 Error en BD o script anterior

### **Impacto de Duplicados**

❌ **Estadísticas rotas** → Contar tutores incorrectamente  
❌ **Emails duplicados** → Confirmaciones múltiples  
❌ **Confusion de datos** → Múltiples perfiles para 1 persona  
❌ **Reseñas divididas** → El tutor tiene calificaciones en 2 perfiles  
❌ **Pagos confusos** → Múltiples cuentas de pago

### **Sección A: Duplicados por EMAIL (Lo más probable)**

```sql
-- Busca: ¿Cuántos tutores comparten el MISMO email?
SELECT email, COUNT(*) as cantidad FROM users
GROUP BY email HAVING COUNT(*) > 1
```

**Resultado:**
```
email                  | CANTIDAD_PERFILES | IDS_TUTORES | NOMBRES          | TELÉFONOS
diego@example.com      | 2                 | 101,456     | Diego, Diego     | 591234..., NULL
maria@example.com      | 3                 | 201,202,203 | Maria, M., Maria | ..., ..., ...
```

**Análisis:**
- ✅ Si cantidad > 1 → **DEFINITIVAMENTE DUPLICADO**
- ✅ Si nombres iguales → Misma persona, 100% seguro
- ⚠️ Si nombres varían → Posible nickname, probable duplicado
- 🔍 Si teléfonos varían → Posible cambio, investigar

### **Sección B: Duplicados por NOMBRE COMPLETO**

```sql
-- Busca: ¿Cuántos tutores tienen el MISMO NOMBRE pero distinto email?
SELECT CONCAT(first_name, last_name) as nombre, COUNT(*) 
FROM profiles GROUP BY nombre HAVING COUNT(*) > 1
```

**Acción:** Verificar si son personas diferentes o mismo usuario

### **Sección C: Duplicados por TELÉFONO**

```sql
-- Busca: ¿Cuántos tutores comparten el MISMO TELÉFONO?
SELECT phone_number, COUNT(*) 
FROM profiles WHERE phone_number IS NOT NULL
GROUP BY phone_number HAVING COUNT(*) > 1
```

**Análisis:**
- ✅ Mismo teléfono + mismo email = **DUPLICADO SEGURO**
- ⚠️ Mismo teléfono + emails distintos = **PROBABLE ERROR DE DATOS**

---

## 🔗 SCRIPT 11: Consolidar Duplicados

### **¿Cuándo usar?**

Cuando SCRIPT 10 encontró duplicados y necesitas decidir:
- ¿Cuál perfil MANTENER?
- ¿Cuál perfil ELIMINAR?

### **Muestra para cada email duplicado:**

```
DUPLICADO_NUM | ID_TUTOR | NOMBRE | TELÉFONO | EMAIL_VERIFICADO | 
ESTADO_IDENTIDAD | FECHA_REGISTRO | TOTAL_IDENTIDADES_DUPLICADAS
```

### **Cómo leer los resultados:**

Para email `diego@example.com` (2 duplicados):

```
DUPLICADO_NUM=1 (MÁS ANTIGUO - Primero en registrarse)
├─ ID: 101
├─ Nombre: Diego González  
├─ Teléfono: 591234567890 ✅ Completo
├─ Email verificado: Sí ✅
├─ Identidad: ✅ APROBADO
├─ Registro: 2024-01-15 (antiguo)
└─ RECOMENDACIÓN: ✅ MANTENER (principal, completo, aprobado)

DUPLICADO_NUM=2 (MÁS RECIENTE - Probablemente error)
├─ ID: 456
├─ Nombre: D. Gonzalez (variante)
├─ Teléfono: NULL ❌ Vacío
├─ Email verificado: No ❌
├─ Identidad: No enviaron ❌
├─ Registro: 2024-09-20 (reciente)
└─ RECOMENDACIÓN: ❌ ELIMINAR (incompleto, sin verificar)
```

### **Criterios de Decisión (en orden)**

| Criterio | Mantener | Eliminar |
|----------|----------|----------|
| ✅ Identidad aprobada | SÍ | NO |
| 📧 Email verificado | SÍ | NO |
| 📱 Tiene teléfono | SÍ | NO |
| 📅 Más antiguo | SÍ | NO |
| 💼 Más datos completos | SÍ | NO |

---

## 📁 Archivos Generados

### **1. SCRIPTS_SQL_TUTORES_VERIFICACION.sql** (Actualizado)

Archivo principal con todos los scripts:
- Scripts 1-7: Existentes (análisis general)
- **Scripts 8-11: NUEVOS (listas limpias + duplicados)**

Ubicación:
```
/home/diego/dev/web/php/ClassGoweb/SCRIPTS_SQL_TUTORES_VERIFICACION.sql
```

### **2. ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md** (Nuevo)

Documentación técnica completa:
- Estructura de BD explicada
- Campos de contacto disponibles
- Procedimiento de limpieza
- FAQ y troubleshooting

Ubicación:
```
/home/diego/dev/web/php/ClassGoweb/ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md
```

### **3. GUIA_EJECUCION_SCRIPTS_TUTORES.md** (Nuevo)

Guía paso a paso para ejecutar scripts:
- Herramientas SQL disponibles
- Cómo ejecutar cada script
- Cómo exportar a CSV/Excel
- Solución de problemas

Ubicación:
```
/home/diego/dev/web/php/ClassGoweb/GUIA_EJECUCION_SCRIPTS_TUTORES.md
```

### **4. RESUMEN_EJECUTIVO_TUTORES.md** (Este archivo)

Este documento: resumen visual y rápido

---

## 📊 Matriz de Contacto Disponible

| Tabla | Campo | Disponibilidad | Uso |
|-------|-------|---|---|
| `users` | `email` | 100% ✅ | Contacto oficial |
| `profiles` | `phone_number` | ~70% ⚠️ | Contacto SMS/WhatsApp |
| `user_identity_verifications` | `parent_phone` | ~10% ⚠️ | Padres de menores |
| `user_contacts` | `detail` | ~5% ⚠️ | Contactos alternativos |

**Recomendación:** Usar `email` (siempre disponible) + `phone_number` (cuando existe)

---

## 🚀 Pasos Inmediatos

### **Fase 1: Extracción de Datos** (Hoy)

```bash
1. Abre GUIA_EJECUCION_SCRIPTS_TUTORES.md
2. Ejecuta SCRIPT 8 → Exporta CSV "Tutores_SIN_verificacion.csv"
3. Ejecuta SCRIPT 9 → Exporta CSV "Tutores_CON_verificacion.csv"
4. Ejecuta SCRIPT 10 → Nota resultado de duplicados
5. Si hay duplicados: Ejecuta SCRIPT 11 → Exporta análisis
```

### **Fase 2: Análisis** (Hoy - 1 hora)

```bash
1. Abre CSVs en Excel
2. Cuenta tutores por estado (sin verificación, en revisión, aprobados)
3. Calcula % de avance: Aprobados / Total
4. Identifica tutores sin teléfono (NULL) → necesitarán email
5. Documenta hallazgos principales
```

### **Fase 3: Acción** (Según prioridad)

```bash
1. Contactar tutores sin verificación → Email + SMS
   Archivo: CSV de SCRIPT 8

2. Revisar aprobaciones pendientes → Admin manual
   Archivo: SCRIPT 9 (estado ⏳ EN REVISIÓN)

3. Limpiar duplicados → Eliminar perfiles innecesarios
   Método: Usar análisis de SCRIPT 11
   Seguridad: BACKUP primero
```

---

## 📈 Métricas a Monitorear

Ejecuta regularmente para tracking:

```sql
-- Tutores por estado
SELECT 
    CASE 
        WHEN uiv.id IS NULL THEN 'SIN DOCUMENTOS'
        WHEN uiv.status = 1 THEN 'APROBADO'
        WHEN uiv.status = 0 THEN 'EN REVISIÓN'
        ELSE 'RECHAZADO'
    END as estado,
    COUNT(*) as cantidad,
    ROUND(100*COUNT(*) / (SELECT COUNT(*) FROM users u 
        INNER JOIN model_has_roles mhr ON u.id = mhr.model_id
        INNER JOIN roles r ON mhr.role_id = r.id
        WHERE r.name = 'tutor'), 2) as porcentaje
FROM users u
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
GROUP BY CASE WHEN uiv.id IS NULL THEN 1 ELSE CASE WHEN uiv.status = 1 THEN 2 WHEN uiv.status = 0 THEN 3 ELSE 4 END END;
```

---

## 🔒 Procedimiento de Seguridad

**ANTES de eliminar duplicados:**

1. ✅ **Backup completo** de BD
   ```bash
   mysqldump -u root -p classgo > backup_2026-09-02.sql
   ```

2. ✅ **Prueba en desarrollo** (no producción directo)

3. ✅ **Revisa 2-3 veces** los IDs a eliminar

4. ✅ **Usa SOFT DELETE** (no DELETE físico)
   ```sql
   UPDATE users SET status = 0 WHERE id = 456;
   ```

5. ✅ **Documenta** cambios realizados

---

## 📚 Documentación Relacionada

- **Script SQL:** `SCRIPTS_SQL_TUTORES_VERIFICACION.sql`
- **Análisis técnico:** `ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md`
- **Guía ejecución:** `GUIA_EJECUCION_SCRIPTS_TUTORES.md`
- **Este resumen:** `RESUMEN_EJECUTIVO_TUTORES.md`

---

## ✨ Resumen

| Aspecto | Antes | Después |
|--------|-------|---------|
| Scripts | 7 genéricos | **11 específicos + 4 nuevos** |
| Listas de contacto | No existían | ✅ 2 listas limpias (con/sin verificación) |
| Detección duplicados | Manual | ✅ Automatizado (3 criterios) |
| Análisis duplicados | Inexistente | ✅ Script 11 con consolidación |
| Documentación | Básica | ✅ 3 archivos detallados |
| Exportación a Excel | Complicada | ✅ Fácil (instrucciones paso a paso) |

---

## ❓ Preguntas?

1. **¿Cómo ejecuto los scripts?**  
   → Ver `GUIA_EJECUCION_SCRIPTS_TUTORES.md`

2. **¿Cómo exporto a Excel?**  
   → Sección "Exportar resultados" en la guía

3. **¿Cuál es el campo de teléfono?**  
   → `profiles.phone_number` (puede ser NULL)

4. **¿Cómo elimino duplicados?**  
   → Sección "Procedimiento de Seguridad"

5. **¿Qué es duplicado definitivamente?**  
   → Mismo email = 100% duplicado

---

## 🎯 Próximo Paso

**Abre:** `GUIA_EJECUCION_SCRIPTS_TUTORES.md`

**Y comienza:** Ejecutar SCRIPT 8 para obtener primera lista

---

**Generado:** Septiembre 2, 2026  
**Versión:** 1.0  
**Estado:** ✅ Listo para usar

