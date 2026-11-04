# 🚀 Guía de Ejecución - Scripts de Tutores y Verificación

**Última actualización:** Septiembre 2, 2026

---

## 📋 Índice Rápido

1. ¿Dónde están los scripts?
2. Herramientas para ejecutar
3. Pasos paso a paso
4. Exportar resultados
5. Troubleshooting

---

## 📁 Ubicación de los Scripts

**Archivo principal:**
```
/home/diego/dev/web/php/ClassGoweb/SCRIPTS_SQL_TUTORES_VERIFICACION.sql
```

**Documentación asociada:**
```
/home/diego/dev/web/php/ClassGoweb/ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md
```

Contiene:
- ✅ SCRIPT 1-7: Scripts existentes (análisis general)
- ✨ **SCRIPT 8**: Tutores SIN verificación (NUEVO - Lista limpia)
- ✨ **SCRIPT 9**: Tutores CON verificación (NUEVO - Lista limpia)
- ✨ **SCRIPT 10**: Detectar duplicados (NUEVO - 3 enfoques)
- ✨ **SCRIPT 11**: Consolidar duplicados (NUEVO - Análisis profundo)

---

## 🛠️ Herramientas para Ejecutar Scripts

### **Opción 1: Adminer (Recomendado - Web UI)**

Acceso:
```
http://localhost:8080  (o tu URL de Adminer)
```

Pasos:
1. Inicia sesión con tus credenciales MySQL
2. Selecciona BD `classgo`
3. Click en "SQL command" o "SQL comandos"
4. Copia y pega el script
5. Click "Execute" / "Ejecutar"

**Ventajas:**
- ✅ GUI amigable
- ✅ Exportar a CSV/JSON
- ✅ Ver resultados bonitos
- ✅ No requiere terminal

### **Opción 2: DBeaver (Desktop - Recomendado para análisis)**

Descarga: https://dbeaver.io/download/

Pasos:
1. Abre DBeaver
2. Nueva conexión → MySQL
3. Host: `localhost`, User: `root`, Password: tu contraseña
4. Conecta a BD `classgo`
5. Abre pestaña SQL
6. Copia y pega script
7. Executa (Ctrl+Enter o click play)

**Ventajas:**
- ✅ Muy potente
- ✅ Coloreo de sintaxis
- ✅ Autocompletado
- ✅ Exportar fácil (CSV, Excel, JSON)
- ✅ Múltiples pestañas

### **Opción 3: Terminal MySQL (Avanzado)**

```bash
# Conectar a BD
mysql -u root -p classgo

# Una vez conectado, pega el script:
[pega el SELECT aquí]

# Luego presiona Enter
```

**Ventajas:**
- ✅ Rápido
- ✅ Minimal
- ⚠️ Menos amigable
- ⚠️ Copiar-pegar complejo

### **Opción 4: Laravel Artisan (Si tienes Laravel corriendo)**

```bash
php artisan tinker

# Luego:
DB::statement('SELECT ...')
```

---

## 📊 Paso a Paso: Ejecutar SCRIPT 8 (Tutores SIN verificación)

### **Paso 1: Abrir herramienta SQL**

Elige entre Adminer, DBeaver o Terminal.

### **Paso 2: Conectar a BD classgo**

- Adminer: Selecciona BD en dropdown
- DBeaver: Click en conexión MySQL
- Terminal: `mysql -u root -p classgo`

### **Paso 3: Copiar SCRIPT 8**

Abre archivo:
```
SCRIPTS_SQL_TUTORES_VERIFICACION.sql
```

Busca sección:
```
-- ========================================
-- SCRIPT 8: TUTORES SIN VERIFICACIÓN - LISTA LIMPIA
-- ========================================
```

Copia desde `SELECT` hasta antes de `-- ========================================`

### **Paso 4: Pegar en herramienta SQL**

- **Adminer:** Pestaña "SQL command" → pega → "Execute"
- **DBeaver:** Nueva pestaña SQL → pega → Ctrl+Enter
- **Terminal:** Pega el SELECT → Enter

### **Paso 5: Revisar resultados**

Deberías ver tabla con columnas:
```
nro | ID_Tutor | CORREO | TELÉFONO | NOMBRE_COMPLETO | FECHA_REGISTRO | DÍAS_DESDE_REGISTRO | ESTADO_VERIFICACIÓN | EMAIL_VERIFICADO
```

### **Paso 6: Exportar resultados (Opcional)**

#### **En Adminer:**
1. Corre el script
2. Debajo de resultados → "Export" 
3. Elige formato: CSV, Excel, etc.
4. Download

#### **En DBeaver:**
1. Corre el script
2. Click derecho en tabla de resultados
3. "Export Results Set"
4. Elige CSV o Excel
5. Configura opciones
6. Guardar

#### **En Terminal MySQL:**
```bash
# Guardar en archivo CSV
mysql -u root -p classgo -e "SELECT ... FROM ..." > tutores_sin_verificacion.csv
```

---

## 📊 Paso a Paso: Ejecutar SCRIPT 9 (Tutores CON verificación)

**Exactamente igual que SCRIPT 8**, pero busca:

```
-- ========================================
-- SCRIPT 9: TUTORES CON VERIFICACIÓN - LISTA LIMPIA
-- ========================================
```

**Resultado:** Tutores con ambos documentos (frente + reverso) completados.

**Columnas adicionales:**
- `FECHA_ENVÍO_IDENTIDAD` → Cuándo subieron
- `DÍAS_DESDE_ENVÍO` → Cuántos días hace
- `ESTADO_VERIFICACIÓN` → ✅ Aprobado / ⏳ En revisión / ❌ Rechazado

---

## 🔎 Paso a Paso: Buscar DUPLICADOS (SCRIPT 10)

### **Paso 1: Ejecutar SCRIPT 10 - Sección A (Duplicados por EMAIL)**

Busca:
```
-- A. Duplicados por EMAIL (lo más probable)
```

Copia y ejecuta ese bloque SELECT.

**Resultado:**
```
email | CANTIDAD_PERFILES | IDS_TUTORES | NOMBRES | TELÉFONOS
```

**Interpretación:**
- Si `CANTIDAD_PERFILES > 1` → ⚠️ HAY DUPLICADOS
- `IDS_TUTORES` → IDs a investigar (ej: 101,456,789)
- `NOMBRES` → Si los nombres cambian = probablemente mismo usuario con nicknames
- `TELÉFONOS` → Si varían = posible data entry error

### **Paso 2: Analizar Resultados**

**Caso 1: Email duplicado, todo igual**
```
diego@example.com | 2 | 101,456 | Diego González, Diego González | 591234567890, 591234567890
```
→ **DEFINITIVAMENTE DUPLICADO** - eliminar uno

**Caso 2: Email duplicado, nombres distintos**
```
diego@example.com | 2 | 101,456 | Diego González, D. Gonzalez | 591234567890, NULL
```
→ **PROBABLEMENTE DUPLICADO** - verificar manualmente

### **Paso 3: Ejecutar SCRIPT 10 - Sección B (Duplicados por NOMBRE)**

Busca:
```
-- B. Duplicados por NOMBRE COMPLETO
```

Copia y ejecuta.

**Resultado:** Si el mismo nombre aparece varias veces con emails distintos:
```
NOMBRE_COMPLETO | CANTIDAD_PERFILES | IDS_TUTORES | EMAILS | TELÉFONOS
```

**Acción:**
- Si emails diferentes → Validar si son personas distintas
- Comparar teléfonos
- Revisar fechas de registro
- **Mejor:** Contactar a cada tutor

### **Paso 4: Ejecutar SCRIPT 10 - Sección C (Duplicados por TELÉFONO)**

Busca:
```
-- C. Duplicados por TELÉFONO
```

Copia y ejecuta.

**Resultado:**
```
TELÉFONO | CANTIDAD_PERFILES | IDS_TUTORES | EMAILS | NOMBRES
```

**Acción:**
- Si CANTIDAD > 1 → Mismo teléfono = MUY PROBABLE DUPLICADO
- Revisar emails
- Si emails iguales → ELIMINAR SIN DUDAS
- Si emails diferentes → Contactar y preguntar

---

## 🔗 Paso a Paso: Consolidar DUPLICADOS (SCRIPT 11)

**USO:** Cuando ya identificaste duplicados en SCRIPT 10 y necesitas tomar decisión de cuál mantener.

### **Paso 1: Identificar Email Duplicado**

De SCRIPT 10 resultado, toma un email:
```
diego@example.com (tiene 2 perfiles)
```

### **Paso 2: Ejecutar SCRIPT 11**

Busca:
```
-- ========================================
-- SCRIPT 11: CONSOLIDAR INFORMACIÓN DE DUPLICADOS
-- ========================================
```

Copia y ejecuta.

**Resultado para email `diego@example.com`:**
```
DUPLICADO_NUM | CORREO_DUPLICADO | ID_TUTOR | NOMBRE_COMPLETO | TELÉFONO | ESTADO_USUARIO | ...
    1         | diego@example... | 101      | Diego González  | 591234... | 1 (activo)    | ...
    2         | diego@example... | 456      | D. Gonzalez     | NULL     | 1 (activo)    | ...
```

### **Paso 3: Analizar Cada Fila

**DUPLICADO_NUM=1 (más antiguo):**
- Fecha registro: 2024-01-15 ✅ (antiguo)
- Email verificado: Sí ✅
- Teléfono: Presente ✅
- Identidad: ✅ Aprobado ✅
- Rol: Tutor activo ✅
- **RECOMENDACIÓN: MANTENER**

**DUPLICADO_NUM=2 (más nuevo):**
- Fecha registro: 2024-09-20 (reciente, probablemente registro duplicado)
- Email verificado: No
- Teléfono: NULL (vacío)
- Identidad: No enviaron (incompleto)
- Rol: Tutor activo pero sin terminar setup
- **RECOMENDACIÓN: ELIMINAR**

### **Paso 4: Tomar Decisión**

**Criterios (en orden de importancia):**

1. **¿Tiene identidad aprobada?**
   - Sí → MANTENER
   - No → ELIMINAR

2. **¿Tiene email verificado?**
   - Sí → MANTENER
   - No → ELIMINAR

3. **¿Tiene datos completos (teléfono)?**
   - Sí → MANTENER
   - No → ELIMINAR

4. **¿Es más antiguo?**
   - Sí → MANTENER (primer registro)
   - No → ELIMINAR (probablemente creó nuevo por olvido)

### **Paso 5: Documentar Decisión**

Crea una nota o CSV:
```
Email | ID_Mantener | ID_Eliminar | Razón
diego@example.com | 101 | 456 | El ID 456 incompleto, ID 101 aprobado
```

---

## 💾 Exportar Resultados a CSV/Excel

### **Método 1: Adminer (más fácil)**

1. Ejecuta el script
2. Debajo de resultados, haz click en "Export"
3. Elige "CSV"
4. Se descarga automáticamente

### **Método 2: DBeaver (recomendado)**

1. Ejecuta el script
2. Click derecho en tabla de resultados
3. "Export Results Set"
4. Elige "CSV" o "Microsoft Excel"
5. Selecciona opción "Include Headers"
6. Click "Finish"
7. Elige ubicación para guardar

### **Método 3: Manual - Copiar desde Adminer a Excel**

1. Ejecuta script en Adminer
2. Selecciona toda la tabla (Ctrl+A)
3. Copia (Ctrl+C)
4. Abre Excel
5. Pega (Ctrl+V)
6. Guarda como .xlsx

### **Método 4: Terminal a archivo**

```bash
# Guardar resultado en archivo CSV
mysql -u root -p classgo -e "SELECT ... FROM ..." > resultados.csv

# Luego abre resultados.csv en Excel
```

---

## ⚠️ Troubleshooting - Problemas Comunes

### **Problema: "Access denied for user 'root'@'localhost'"**

**Solución:**
```bash
# Reinicia MySQL
sudo service mysql restart

# O si usas XAMPP:
# Windows: Click en "Start" en XAMPP Control Panel
# Mac: /Applications/XAMPP/xamppfiles/bin/mysql.server restart
```

### **Problema: "Unknown database 'classgo'"**

**Verificar:**
1. BD existe en MySQL
2. Nombre exacto es `classgo` (case-sensitive en Linux)
3. Conectaste a la BD correcta

**Solución:**
```bash
# Ver BDs disponibles
mysql -u root -p -e "SHOW DATABASES;"
```

### **Problema: Script devuelve "0 rows"**

**Posibles causas:**

1. **No hay tutores sin verificación:**
   ```sql
   -- Verifica que existen tutores
   SELECT COUNT(*) FROM users u
   INNER JOIN model_has_roles mhr ON u.id = mhr.model_id
   INNER JOIN roles r ON mhr.role_id = r.id
   WHERE r.name = 'tutor';
   ```

2. **Todos los tutores ya verificaron:**
   - Es buena noticia, significa que SCRIPT 8 devuelve 0 filas

3. **Tabla roles.name no es exactamente 'tutor':**
   ```sql
   -- Verifica el nombre exacto
   SELECT DISTINCT name FROM roles;
   ```

### **Problema: Error de sintaxis SQL**

**Síntomas:**
```
"SQL Error: You have an error in your SQL syntax..."
```

**Solución:**
1. Copia SOLO el bloque del script que necesitas
2. Verifica que no haya caracteres especiales extraños
3. Pega en herramienta SQL limpia
4. Si persiste: ejecuta scripts 1-7 primero (que ya funcionan)

### **Problema: Adminer no muestra exportar**

**Solución:**
1. Asegúrate de que el script devolvió resultados (algo más de 0 filas)
2. Si hay resultados, opción "Export" debe aparecer debajo
3. Si no aparece: intenta en DBeaver

---

## 🎯 Checklist de Ejecución

**Antes de empezar:**
- ✅ Acceso a BD classgo confirmado
- ✅ Tengo herramienta SQL abierta (Adminer / DBeaver / Terminal)
- ✅ Archivo SCRIPTS_SQL_TUTORES_VERIFICACION.sql a mano

**Ejecución:**
- ✅ Ejecuté SCRIPT 8 (Tutores SIN verificación)
- ✅ Revisé resultados
- ✅ Ejecuté SCRIPT 9 (Tutores CON verificación)
- ✅ Revisé resultados
- ✅ Ejecuté SCRIPT 10 - Sección A (Duplicados por email)
- ✅ Si hay duplicados: Ejecuté SCRIPT 11
- ✅ Exporté resultados a CSV

**Post-ejecución:**
- ✅ Tengo listas descargadas
- ✅ Documenté hallazgos principales
- ✅ Preparé acciones (contactar, eliminar duplicados)

---

## 📞 Próximos Pasos Después de Ejecutar

### **Con SCRIPT 8 (Sin verificación):**

```
1. Exporta a CSV
2. Abre en Excel
3. Cuenta por estado de verificación
4. Prepara email automatizado o manual
5. Contacta a cada tutor con su correo + teléfono
6. Envía link a verificar identidad
7. Establece deadline (ej: 30 días)
```

### **Con SCRIPT 9 (Con verificación):**

```
1. Exporta a CSV
2. Cuenta aprobados vs en revisión vs rechazados
3. Revisa rechazados = oportunidad de contacto
4. Genera reporte de "tutores listos"
5. Para estadísticas de auditoría
```

### **Si encontraste duplicados (SCRIPT 10 + 11):**

```
1. Exporta resultados de SCRIPT 11
2. Documenta decisión para cada grupo
3. Después de confirmar: ejecuta script de limpieza
4. Verifica integridad (sin errores de FK)
5. Haz backup de cambios
```

---

## 📚 Recursos Adicionales

- **Documentación completa:** `ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md`
- **Todos los scripts:** `SCRIPTS_SQL_TUTORES_VERIFICACION.sql`
- **BD estructura:** Ver migrations en `database/migrations/`

---

## ❓ Preguntas? 

Revisa la sección "Preguntas Frecuentes" en:
```
ANALISIS_Y_LISTA_TUTORES_VERIFICACION.md
```

O busca en comentarios de los scripts mismos.

**¡Listo para ejecutar! 🚀**

