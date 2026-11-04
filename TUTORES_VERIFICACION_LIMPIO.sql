-- ========================================
-- SCRIPT 1: TUTORES VERIFICADOS
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY uiv.updated_at DESC) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    p.phone_number as 'TELÉFONO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    u.created_at as 'FECHA_REGISTRO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
INNER JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND uiv.status = 1
ORDER BY uiv.updated_at DESC;

-- ========================================
-- SCRIPT 2: TUTORES NO VERIFICADOS
-- ========================================

SELECT 
    ROW_NUMBER() OVER (ORDER BY u.created_at DESC) as 'nro',
    u.id as 'ID_Tutor',
    u.email as 'CORREO',
    p.phone_number as 'TELÉFONO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    u.created_at as 'FECHA_REGISTRO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND (
        uiv.id IS NULL
        OR uiv.status IS NULL
        OR uiv.status != 1
    )
ORDER BY u.created_at DESC;FONO',
    CONCAT(p.first_name, ' ', p.last_name) as 'NOMBRE_COMPLETO',
    u.created_at as 'FECHA_REGISTRO'
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor'
    AND (
        uiv.id IS NULL
        OR uiv.status IS NULL
        OR uiv.status != 'accepted'
    )
ORDER BY u.created_at DESC;
