# Ejemplo de Resultados con Numeración

He agregado una columna `nro` (numeración) a todos los scripts para que veas fácilmente la posición de cada tutor.

---

## 📊 SCRIPT 3: RESUMEN GENERAL (Ejemplo)

```
nro | ID_Tutor | email                    | nombre_completo      | ESTADO_IDENTIDAD  | RESULTADO_VERIFICACION
----+----------+------------------------+-----------------------+-------------------+------------------------
1   | 45       | juan.perez@email.com    | Juan Pérez            | 1️⃣ NO ENVIADO    | —
2   | 67       | maria.garcia@email.com  | María García          | 1️⃣ NO ENVIADO    | —
3   | 89       | carlos.lopez@email.com  | Carlos López          | 2️⃣ INCOMPLETO    | ⏳ En revisión
4   | 23       | ana.rodriguez@email.com | Ana Rodríguez         | ✅ COMPLETO       | ⏳ En revisión
5   | 12       | pedro.sanchez@email.com | Pedro Sánchez         | ✅ COMPLETO       | ✅ Aprobado
6   | 34       | lucia.martin@email.com  | Lucía Martín          | ✅ COMPLETO       | ✅ Aprobado
7   | 56       | diego.torres@email.com  | Diego Torres          | ✅ COMPLETO       | ❌ Rechazado
```

### Cómo leer esto:

- **nro 1** = Primer tutor sin envío (Juan Pérez, ID 45)
- **nro 2** = Segundo tutor sin envío (María García, ID 67)
- **nro 3** = Primer tutor con envío incompleto (Carlos López, ID 89)
- **nro 4** = Primer tutor con envío completo (Ana Rodríguez, ID 23)
- **nro 5-6** = Tutores con envío completo y aprobados
- **nro 7** = Tutor con envío completo pero rechazado

---

## 📋 SCRIPT 2: TUTORES SIN VERIFICACIÓN (Ejemplo)

```
nro | id  | email              | nombre_completo  | dias_desde_registro | email_verificado
----+-----+--------------------+------------------+---------------------+------------------
1   | 45  | juan@email.com     | Juan Pérez       | 120                 | SÍ verificado
2   | 67  | maria@email.com    | María García     | 95                  | SÍ verificado
3   | 89  | carlos@email.com   | Carlos López     | 45                  | NO verificado
4   | 23  | ana@email.com      | Ana Rodríguez    | 30                  | SÍ verificado
5   | 112 | luis@email.com     | Luis Martínez    | 15                  | NO verificado
```

### Cómo leer esto:

- **nro 1** = Primer tutor que falta (Juan - lleva 120 días sin verificar)
- **nro 2** = Segundo tutor que falta (María - lleva 95 días)
- **nro 3-5** = Más tutores que necesitan recordatorio

---

## 📧 SCRIPT 4: EXPORTAR PARA CONTACTAR (Ejemplo)

```
nro | id  | email              | nombre_completo      | estado                         | dias_desde_registro
----+-----+--------------------+----------------------+--------------------------------+---------------------
1   | 45  | juan@email.com     | Juan Pérez           | No ha subido documentos        | 120
2   | 67  | maria@email.com    | María García         | No ha subido documentos        | 95
3   | 89  | carlos@email.com   | Carlos López         | Subió documentos incompletos   | 45
4   | 23  | ana@email.com      | Ana Rodríguez        | Subió documentos incompletos   | 30
5   | 112 | luis@email.com     | Luis Martínez        | No ha subido documentos        | 15
```

**Uso:** Copia estos emails para enviar recordatorios masivos

---

## ✨ ¿Qué cambió?

### Antes (sin numeración):
```
| ID | Email | Nombre |
|----+-------+--------|
| 45 | juan@email.com | Juan |
```

### Ahora (con numeración):
```
| nro | ID | Email | Nombre |
|-----+----+-------+--------|
| 1   | 45 | juan@email.com | Juan |
| 2   | 67 | maria@email.com | María |
```

Ahora es mucho más fácil decir **"el tutor número 5 necesita contacto"** en lugar de buscar por ID.

---

## 🎯 Beneficios

1. **Fácil referencia**: "El número 23 necesita resubir documentos"
2. **Ordena automáticamente**: Los más urgentes primero
3. **Seguimiento**: Puedes anotar "contacté al nro 5"
4. **Legibilidad**: Al lado del ID, no confunde

---

## 📍 Dónde está la numeración

**En los siguientes scripts:**
- ✅ Script 1: Tutores que SÍ verificaron (ordenado por fecha envío)
- ✅ Script 2: Tutores que NO verificaron (ordenado por antigüedad)
- ✅ Script 3: Resumen general (ordenado por prioridad: sin envío → incompleto → rechazado → aprobado)
- ✅ Script 4: Exportar para contactar (ordenado por antigüedad)
- ✅ Script 6: Detalle de 1 tutor (siempre "1" porque es un solo resultado)
- ✅ Script 7: Documentos incompletos (ordenado por antigüedad)

**Script 5 (Estadísticas):** No tiene numeración porque agrupa por estado

---

## 🚀 Cómo usar

Ejecuta cualquiera de los scripts y verás la numeración al lado del ID:

```sql
-- SCRIPT 3 (RECOMENDADO)
SELECT 
    ROW_NUMBER() OVER (...) as 'nro',  ← ESTA ES LA NUEVA COLUMNA
    u.id as 'ID_Tutor',
    u.email,
    ...
```

Resultado:
```
nro | ID_Tutor | email | ...
1   | 45       | juan@... | ...
2   | 67       | maria@... | ...
```

Listo para usar. 🎉
