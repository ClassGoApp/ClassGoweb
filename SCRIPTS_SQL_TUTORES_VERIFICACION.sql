-- ========================================
-- SCRIPTS SQL - VERIFICACIÓN DE IDENTIDAD
-- ========================================
-- Ejecuta estos scripts en tu base de datos de PRODUCCIÓN
-- Base de datos: ClassGo
-- Última actualización: 31 de Agosto, 2026
-- IMPORTANTE: Los roles están en la tabla 'roles' con relación 'model_has_roles'

-- ========================================
-- SCRIPT 1: Tutores que YA enviaron verificación
-- ========================================
-- Muestra tutores que completaron la subida de documentos
-- Resultado: tutores con fotos frente y reverso

SELECT 
    ROW_NUMBER() OVER (ORDER BY uiv.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    uiv.created_at as 'fecha_envio_identidad',
    uiv.status as 'codigo_estado',
    CASE 
        WHEN uiv.status = 0 THEN 'Pendiente revisión'
        WHEN uiv.status = 1 THEN 'Aprobado ✅'
        WHEN uiv.status = 2 THEN 'Rechazado ❌'
        ELSE 'Desconocido'
    END as 'estado_verificacion',
    JSON_EXTRACT(uiv.attachments, '$.front') as 'foto_frontal_archivo',
    JSON_EXTRACT(uiv.attachments, '$.back') as 'foto_trasera_archivo',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO ✓'
        ELSE 'INCOMPLETO ✗'
    END as 'estado_documentos'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
ORDER BY uiv.created_at DESC;

-- ========================================
-- SCRIPT 2: Tutores que NO enviaron verificación
-- ========================================
-- Muestra tutores que nunca subieron documentos de identidad
-- Estos son los que necesitan recordatorio urgente

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    DATEDIFF(NOW(), u.created_at) as 'dias_desde_registro',
    CASE 
        WHEN u.email_verified_at IS NOT NULL THEN 'SÍ verificado'
        ELSE 'NO verificado'
    END as 'email_verificado'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
WHERE r.name = 'tutor' 
    AND u.id NOT IN (
        SELECT DISTINCT user_id 
        FROM user_identity_verifications 
        WHERE attachments IS NOT NULL
    )
ORDER BY u.created_at DESC;

-- ========================================
-- SCRIPT 3: RESUMEN GENERAL (RECOMENDADO)
-- ========================================
-- Este es el más útil: muestra TODOS los tutores con su estado
-- Prioriza los que faltan documentos

SELECT 
    ROW_NUMBER() OVER (ORDER BY 
        CASE 
            WHEN uiv.id IS NULL THEN 1
            WHEN uiv.attachments IS NULL THEN 2
            WHEN uiv.status = 2 THEN 3
            ELSE 4
        END,
        u.created_at DESC
    ) as 'nro',
    u.id as 'ID_Tutor',
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    CASE 
        WHEN uiv.id IS NULL THEN '1️⃣ NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN '2️⃣ INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN '✅ COMPLETO'
        ELSE '⚠️ ERROR'
    END as 'ESTADO_IDENTIDAD',
    CASE 
        WHEN uiv.status = 1 THEN '✅ Aprobado'
        WHEN uiv.status = 2 THEN '❌ Rechazado'
        WHEN uiv.status = 0 AND uiv.id IS NOT NULL THEN '⏳ En revisión'
        ELSE '—'
    END as 'RESULTADO_VERIFICACION',
    uiv.created_at as 'fecha_ultimo_envio',
    DATEDIFF(NOW(), u.created_at) as 'dias_desde_registro'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
ORDER BY 
    CASE 
        WHEN uiv.id IS NULL THEN 1
        WHEN uiv.attachments IS NULL THEN 2
        WHEN uiv.status = 2 THEN 3
        ELSE 4
    END,
    u.created_at DESC;

-- ========================================
-- SCRIPT 4: EXPORTAR PARA CONTACTAR
-- ========================================
-- Exporta email + nombre para contactar a tutores pendientes
-- Ideal para copiar a un CSV o gestor de emails

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    CASE 
        WHEN uiv.id IS NULL THEN 'No ha subido documentos'
        WHEN uiv.attachments IS NULL THEN 'Subió documentos incompletos'
        ELSE 'Completó subida'
    END as 'estado',
    DATEDIFF(NOW(), u.created_at) as 'dias_desde_registro'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND (uiv.id IS NULL OR uiv.attachments IS NULL)
ORDER BY u.created_at DESC;

-- ========================================
-- SCRIPT 5: CONTAR POR ESTADO
-- ========================================
-- Resumen de estadísticas: cuántos en cada estado

SELECT 
    CASE 
        WHEN uiv.id IS NULL THEN 'NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN 'INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'ERROR'
    END as 'ESTADO',
    COUNT(u.id) as 'CANTIDAD_TUTORES',
    ROUND(COUNT(u.id) * 100 / (
        SELECT COUNT(*) FROM users u2
        INNER JOIN model_has_roles mhr2 ON u2.id = mhr2.model_id AND mhr2.model_type = 'App\\Models\\User'
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
        WHEN uiv.id IS NULL THEN 'NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN 'INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'ERROR'
    END
ORDER BY 
    CASE 
        WHEN uiv.id IS NULL THEN 1
        WHEN uiv.attachments IS NULL THEN 2
        ELSE 3
    END;

-- ========================================
-- SCRIPT 6: VER DETALLES DE UN TUTOR
-- ========================================
-- Cambia 123 por el ID del tutor que quieras investigar

SELECT 
    1 as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    p.phone,
    u.created_at as 'fecha_registro',
    u.email_verified_at as 'email_verificado_en',
    uiv.status as 'codigo_estado_identidad',
    CASE 
        WHEN uiv.status = 0 THEN 'Pendiente'
        WHEN uiv.status = 1 THEN 'Aprobado'
        WHEN uiv.status = 2 THEN 'Rechazado'
    END as 'estado_identidad',
    uiv.created_at as 'fecha_envio_identidad',
    uiv.attachments as 'json_fotos',
    JSON_EXTRACT(uiv.attachments, '$.front') as 'foto_frontal',
    JSON_EXTRACT(uiv.attachments, '$.back') as 'foto_trasera',
    uiv.personal_photo as 'foto_personal'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.id = 123 AND r.name = 'tutor';

-- ========================================
-- SCRIPT 7: DOCUMENTOS INCOMPLETOS (Detalle)
-- ========================================
-- Muestra qué documentos faltan por tutor

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NULL 
            THEN 'Falta foto frontal'
        WHEN JSON_EXTRACT(uiv.attachments, '$.back') IS NULL 
            THEN 'Falta foto trasera'
        ELSE 'Completado'
    END as 'falta_documento',
    uiv.created_at as 'fecha_ultimo_intento'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.id IS NOT NULL
    AND uiv.attachments IS NULL
ORDER BY u.created_at DESC;

-- ========================================
-- SCRIPT 8: TUTORES SIN VERIFICACIÓN - LISTA LIMPIA
-- ========================================
-- ✅ TUTORES NO VERIFICADOS (sin documentos o incompletos)
-- Información de contacto: correo + teléfono
-- Sin duplicados (agrupado por email único)
-- Ordenado por fecha de registro (más recientes primero)

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

-- ========================================
-- SCRIPT 9: TUTORES CON VERIFICACIÓN - LISTA LIMPIA
-- ========================================
-- ✅ TUTORES VERIFICADOS (con documentos completos)
-- Información de contacto: correo + teléfono
-- Sin duplicados (agrupado por email único)
-- Ordenado por estado de aprobación

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

-- ========================================
-- SCRIPT 10: DETECTAR PERFILES DUPLICADOS
-- ========================================
-- Identifica tutores potencialmente duplicados
-- Se busca por: mismo email, mismo nombre completo, mismo teléfono

-- A. Duplicados por EMAIL (lo más probable)
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

-- B. Duplicados por NOMBRE COMPLETO (si hay registros con distinto email)
SELECT 
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    COUNT(p.user_id) as 'CANTIDAD_PERFILES',
    GROUP_CONCAT(u.id) as 'IDS_TUTORES',
    GROUP_CONCAT(u.email) as 'EMAILS',
    GROUP_CONCAT(p.phone_number) as 'TELÉFONOS'
FROM profiles p
INNER JOIN users u ON p.user_id = u.id
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
WHERE r.name = 'tutor'
GROUP BY CONCAT(p.first_name, ' ', p.last_name)
HAVING COUNT(p.user_id) > 1
ORDER BY COUNT(p.user_id) DESC;

-- C. Duplicados por TELÉFONO (si hay múltiples perfiles con mismo teléfono)
SELECT 
    p.phone_number as 'TELÉFONO',
    COUNT(p.user_id) as 'CANTIDAD_PERFILES',
    GROUP_CONCAT(u.id) as 'IDS_TUTORES',
    GROUP_CONCAT(u.email) as 'EMAILS',
    GROUP_CONCAT(CONCAT(p.first_name, ' ', p.last_name)) as 'NOMBRES'
FROM profiles p
INNER JOIN users u ON p.user_id = u.id
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
WHERE r.name = 'tutor' AND p.phone_number IS NOT NULL
GROUP BY p.phone_number
HAVING COUNT(p.user_id) > 1
ORDER BY COUNT(p.user_id) DESC;

-- ========================================
-- SCRIPT 11: CONSOLIDAR INFORMACIÓN DE DUPLICADOS
-- ========================================
-- Muestra TODOS los datos de tutores duplicados (para análisis manual)
-- Útil antes de decidir cuál perfil mantener

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

-- ========================================
-- EXPLICACIÓN DE ESTADOS
-- ========================================
/*
STATUS EN user_identity_verifications:
  0 = Pendiente (subió documentos, esperando revisión)
  1 = Aprobado (verificación completada, puede acceder)
  2 = Rechazado (documentos inválidos, necesita resubir)
  NULL = No ha subido nada

ATTACHMENTS (campo JSON):
  {
    "front": "identity_photo/nombre-id-front-12345.jpg",
    "back": "identity_photo/nombre-id-back-12345.jpg"
  }
  
  Si ATTACHMENTS IS NULL = No ha subido nada
  Si falta "front" = Solo subió reverso
  Si falta "back" = Solo subió frente
  Si tiene ambas = Completó verificación

TABLA DE ROLES:
  Los tutores están identificados por:
  - Tabla: model_has_roles
  - Campo role.name = 'tutor'
  - Relación: users.id = model_has_roles.model_id (donde model_type = 'App\\Models\\User')
*/

-- ========================================
-- NOTAS IMPORTANTES
-- ========================================
/*
1. Los tutores necesitan AMBAS fotos (frente y reverso) para completar
2. Si una foto es NULL, el estado es INCOMPLETO
3. Una vez completo, tú (admin) puedes aprobar o rechazar
4. Si rechazas, el tutor puede resubir
5. El nombre está en tabla PROFILES (first_name + last_name)
6. El estado está en USER_IDENTITY_VERIFICATIONS
7. Los roles están en ROLES + MODEL_HAS_ROLES (no en users directamente)
8. El teléfono está en PROFILES.phone_number (agregado en Nov 2024)
9. Para evitar duplicados: agrupá por EMAIL (es único en tabla users)

ESTRUCTURA DE DATOS:
  users → model_has_roles → roles (relación N:N)
  users → profiles (1:1)
  users → user_identity_verifications (1:1)

CAMPOS DE CONTACTO:
  - profiles.phone_number → Teléfono principal del usuario/tutor
  - user_identity_verifications.parent_phone → Teléfono del padre (solo menores)
  - user_contacts.detail → Múltiples contactos alternativos (phone, whatsapp, etc)
*/
