-- ========================================
-- SCRIPT SQL - TUTORES IDENTIDAD VERIFICADOS
-- ========================================
-- Muestra tutores verificados por identidad (carnet frontal + reverso)
-- Filtra por estado: Verificado (1) o Pendiente (0)
-- Exclude: Rechazados (2)
-- ========================================

-- SCRIPT 1: TUTORES VERIFICADOS O PENDIENTE (Identidad)
-- =======================================================
-- Muestra tutores con verificación de identidad completada o en revisión
-- Estado Verificado: status = 1 (Aprobado)
-- Estado Pendiente: status = 0 (En revisión)
-- Excluye: status = 2 (Rechazado)

SELECT 
    ROW_NUMBER() OVER (ORDER BY 
        CASE WHEN uiv.status = 1 THEN 0 ELSE 1 END,
        uiv.created_at DESC
    ) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    p.phone_number as 'TELÉFONO',
    uiv.created_at as 'FECHA_ENVÍO',
    CASE 
        WHEN uiv.status = 1 THEN '✅ VERIFICADO'
        WHEN uiv.status = 0 THEN '⏳ PENDIENTE'
        WHEN uiv.status = 2 THEN '❌ RECHAZADO'
        ELSE 'Desconocido'
    END as 'ESTADO_VERIFICACIÓN',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'Completo ✓'
        WHEN uiv.attachments IS NULL THEN 'No subido'
        ELSE 'Incompleto'
    END as 'ESTADO_DOCUMENTOS',
    DATEDIFF(NOW(), uiv.created_at) as 'DÍAS_DESDE_ENVÍO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.status IN (0, 1)  -- Solo Verificado (1) o Pendiente (0), excluye Rechazado (2)
    AND uiv.attachments IS NOT NULL  -- Solo aquellos que subieron documentos
ORDER BY 
    CASE WHEN uiv.status = 1 THEN 0 ELSE 1 END,
    uiv.created_at DESC;

-- ========================================
-- SCRIPT 2: TUTORES SOLAMENTE VERIFICADOS (status=1)
-- ========================================--
-- Muestra solo tutores con verificación Aprobada (status = 1)
-- Estos son los que el admin ya aceptó

SELECT 
    ROW_NUMBER() OVER (ORDER BY uiv.created_at DESC) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    p.phone_number as 'TELÉFONO',
    uiv.created_at as 'FECHA_ENVÍO',
    '✅ VERIFICADO' as 'ESTADO_VERIFICACIÓN',
    'Completo ✓' as 'ESTADO_DOCUMENTOS',
    DATEDIFF(NOW(), uiv.created_at) as 'DÍAS_DESDE_ENVÍO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.status = 1  -- Solo Aprobados/Verificados
    AND JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL
    AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL
ORDER BY uiv.created_at DESC;

-- ========================================
-- SCRIPT 3: TUTORES PENDIENTE REVISIÓN (status=0)
-- ========================================--
-- Muestra tutores con verificación en revisión (status = 0)
-- El admin aún no ha decidido (aceptar o rechazar)

SELECT 
    ROW_NUMBER() OVER (ORDER BY uiv.created_at DESC) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    p.phone_number as 'TELÉFONO',
    uiv.created_at as 'FECHA_ENVÍO',
    '⏳ PENDIENTE' as 'ESTADO_VERIFICACIÓN',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'Completo - esperando decisión'
        WHEN uiv.attachments IS NULL THEN 'No subido - esperando subida'
        ELSE 'Incompleto - esperando documentación'
    END as 'ESTADO_DOCUMENTOS',
    DATEDIFF(NOW(), uiv.created_at) as 'DÍAS_DESDE_ENVÍO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.status = 0  -- Solo Pendiente/En revisión
ORDER BY uiv.created_at DESC;

-- ========================================
-- SCRIPT 4: RESUMEN ESTADOS VERIFICACIÓN IDENTIDAD
-- ========================================--
-- Cuenta tutores por estado de verificación de identidad

SELECT 
    CASE 
        WHEN uiv.status = 1 THEN 'VERIFICADO ✅'
        WHEN uiv.status = 0 THEN 'PENDIENTE ⏳'
        WHEN uiv.status = 2 THEN 'RECHAZADO ❌'
        WHEN uiv.id IS NULL THEN 'NO ENVIÓ'
        ELSE 'OTRO'
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
GROUP BY uiv.status
ORDER BY 
    CASE 
        WHEN uiv.status = 1 THEN 1
        WHEN uiv.status = 0 THEN 2
        WHEN uiv.status = 2 THEN 3
        WHEN uiv.id IS NULL THEN 4
        ELSE 5
    END;
