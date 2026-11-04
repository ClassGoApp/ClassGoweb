# Verificación de Identidad - Guía Limpia

## 📌 Lo Importante

**Verificación de identidad** = Tutores que suban fotos del carnet (frente + reverso)

**Nada más. Sin términos. Sin condiciones. Solo eso.**

---

## 🚀 Cómo Usar

### Ejecuta el archivo:
```
SCRIPTS_VERIFICACION_IDENTIDAD_LIMPIO.sql
```

### Tiene 7 scripts:

| Script | Qué hace | Cuándo usar |
|--------|----------|------------|
| **1** | Tutores que SÍ verificaron | Ver quiénes completaron |
| **2** | Tutores que NO verificaron | Contactarlos |
| **3** | RESUMEN (el mejor) | Visión general rápida |
| **4** | Contar por estado | Estadísticas |
| **5** | Exportar emails | Enviar recordatorios |
| **6** | Detalles de 1 tutor | Investigar caso |
| **7** | Qué falta | Contactar de forma específica |

---

## 🎯 Los 4 Estados

```
1. NO ENVIADO      = Nunca subió nada
2. INCOMPLETO      = Subió pero falta algo (ej: solo frente, sin reverso)
3. COMPLETO        = Subió ambas fotos
4. APROBADO ✅     = Ya fue revisado y aprobado
```

---

## 📊 Script 3 (El mejor)

Ejecuta **SCRIPT 3** y verás:

```
nro | id  | email          | nombre   | estado_envio | resultado
----|-----|----------------|----------|--------------|---------------
1   | 45  | juan@email.com | Juan     | NO ENVIADO   | —
2   | 67  | maria@email.com| María    | INCOMPLETO   | EN REVISIÓN
3   | 89  | carlos@email.com| Carlos  | COMPLETO     | APROBADO ✅
```

**Eso es todo lo que necesitas.**

---

## ✨ Eso

- ✅ Verificación de identidad (carnet frente + reverso)
- ✅ Estado del envío (no enviado / incompleto / completo)
- ✅ Resultado de verificación (pendiente / aprobado / rechazado)
- ✅ Numeración para fácil referencia

**Nada de términos. Nada de condiciones. Solo eso.**

---

## 📧 Para Contactar Tutores

Ejecuta **SCRIPT 5**:

```
nro | id | email          | nombre
----|----|----|-------|----
1   | 45 | juan@email.com | Juan
2   | 67 | maria@email.com| María
```

Copia estos emails y envía recordatorio: *"Por favor, verifica tu identidad subiendo tu carnet (frente y reverso)"*

---

## 🔧 Cambios vs Versiones Anteriores

**Removido:**
- ❌ Términos aceptados
- ❌ Condiciones de servicio
- ❌ Filtros adicionales
- ❌ Complexidad innecesaria

**Mantiene:**
- ✅ Verificación de identidad
- ✅ Numeración (nro)
- ✅ Estados claros
- ✅ 7 scripts útiles

---

## ✅ Listo

Sin complicaciones. Sin confusiones. Solo verificación de identidad.

¡A usar! 🚀
