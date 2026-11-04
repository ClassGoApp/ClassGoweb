-- ========================================
-- SCRIPTS SQL - VERIFICACIÓN DE IDENTIDAD
-- LIMPIO - Solo lo que importa
-- ========================================
-- Sin términos, sin condiciones, sin nada más
-- Solo verificación de identidad (carnet frontal + reverso)

-- ========================================
-- SCRIPT 1: Tutores CON verificación
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY uiv.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    uiv.created_at as 'fecha_envio',
    uiv.status as 'estado_codigo',
    CASE 
        WHEN uiv.status = 0 THEN 'Pendiente'
        WHEN uiv.status = 1 THEN 'Aprobado ✅'
        WHEN uiv.status = 2 THEN 'Rechazado ❌'
        ELSE 'Otro'
    END as 'estado',
    JSON_EXTRACT(uiv.attachments, '$.front') as 'foto_frente',
    JSON_EXTRACT(uiv.attachments, '$.back') as 'foto_reverso'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
ORDER BY uiv.created_at DESC;

-- ========================================
-- SCRIPT 2: Tutores SIN verificación
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre_completo',
    u.created_at as 'fecha_registro',
    DATEDIFF(NOW(), u.created_at) as 'dias_sin_verificar'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
WHERE r.name = 'tutor' 
    AND u.id NOT IN (SELECT DISTINCT user_id FROM user_identity_verifications WHERE attachments IS NOT NULL)
ORDER BY u.created_at DESC;

-- ========================================
-- SCRIPT 3: RESUMEN - Estado de verificación
-- ========================================

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
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre',
    CASE 
        WHEN uiv.id IS NULL THEN 'NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN 'INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'ERROR'
    END as 'estado_envio',
    CASE 
        WHEN uiv.status = 1 THEN 'APROBADO ✅'
        WHEN uiv.status = 2 THEN 'RECHAZADO ❌'
        WHEN uiv.status = 0 AND uiv.id IS NOT NULL THEN 'EN REVISIÓN ⏳'
        ELSE '—'
    END as 'resultado'
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
-- SCRIPT 4: Contar por estado
-- ========================================

SELECT 
    CASE 
        WHEN uiv.id IS NULL THEN 'NO ENVIADO'
        WHEN uiv.attachments IS NULL THEN 'INCOMPLETO'
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NOT NULL 
            AND JSON_EXTRACT(uiv.attachments, '$.back') IS NOT NULL 
        THEN 'COMPLETO'
        ELSE 'ERROR'
    END as 'estado',
    COUNT(u.id) as 'cantidad',
    ROUND(COUNT(u.id) * 100 / (SELECT COUNT(*) FROM users u2 
        INNER JOIN model_has_roles mhr2 ON u2.id = mhr2.model_id 
        INNER JOIN roles r2 ON mhr2.role_id = r2.id 
        WHERE r2.name = 'tutor'), 2) as 'porcentaje'
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
-- SCRIPT 5: Exportar para contactar
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
WHERE r.name = 'tutor' 
    AND u.id NOT IN (SELECT DISTINCT user_id FROM user_identity_verifications WHERE attachments IS NOT NULL)
ORDER BY u.created_at DESC;

-- ========================================
-- SCRIPT 6: Detalles de 1 tutor
-- ========================================
-- Cambia 123 por el ID del tutor

SELECT 
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre',
    u.created_at as 'fecha_registro',
    uiv.status as 'estado_codigo',
    uiv.created_at as 'fecha_envio',
    uiv.attachments as 'json_fotos',
    JSON_EXTRACT(uiv.attachments, '$.front') as 'foto_frente',
    JSON_EXTRACT(uiv.attachments, '$.back') as 'foto_reverso'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE u.id = 123 AND r.name = 'tutor';

-- ========================================
-- SCRIPT 7: Incompletos - Qué falta
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as 'nombre',
    CASE 
        WHEN JSON_EXTRACT(uiv.attachments, '$.front') IS NULL 
            THEN 'Falta frente'
        WHEN JSON_EXTRACT(uiv.attachments, '$.back') IS NULL 
            THEN 'Falta reverso'
        ELSE 'Completado'
    END as 'falta'
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
-- FIN - 7 Scripts listos
-- ========================================
-- Sin términos, sin condiciones
-- Solo verificación de identidad
