-- ========================================
-- TEST RÁPIDO - Ejecuta ESTO PRIMERO
-- ========================================
-- Este script verifica que tu BD está correcta antes de correr los scripts principales

-- 1. Verificar que existen las tablas
SELECT 'TABLA USERS' as test, COUNT(*) as total FROM users
UNION ALL
SELECT 'TABLA PROFILES', COUNT(*) FROM profiles
UNION ALL
SELECT 'TABLA ROLES', COUNT(*) FROM roles
UNION ALL
SELECT 'TABLA MODEL_HAS_ROLES', COUNT(*) FROM model_has_roles
UNION ALL
SELECT 'TABLA USER_IDENTITY_VERIFICATIONS', COUNT(*) FROM user_identity_verifications;

-- 2. Ver cuántos tutores existen
SELECT 'Total de TUTORES' as descripcion, COUNT(u.id) as cantidad
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
WHERE r.name = 'tutor';

-- 3. Ver cuántos tutores tienen verificación de identidad
SELECT 'Tutores CON verificación' as descripcion, COUNT(DISTINCT u.id) as cantidad
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN user_identity_verifications uiv ON u.id = uiv.user_id
WHERE r.name = 'tutor' AND uiv.id IS NOT NULL;

-- 4. Ver cuántos tutores SIN verificación
SELECT 'Tutores SIN verificación' as descripcion, COUNT(u.id) as cantidad
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
WHERE r.name = 'tutor' AND u.id NOT IN (SELECT DISTINCT user_id FROM user_identity_verifications);

-- 5. Ver 5 tutores aleatorios (para verificar estructura)
SELECT 
    'MUESTRA: 5 tutores aleatorios' as descripcion,
    u.id,
    u.email,
    CONCAT(p.first_name, ' ', p.last_name) as nombre,
    u.created_at
FROM users u
INNER JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\User'
INNER JOIN roles r ON mhr.role_id = r.id
LEFT JOIN profiles p ON u.id = p.user_id
WHERE r.name = 'tutor'
LIMIT 5;

-- ========================================
-- Si todos estos queries funcionan correctamente,
-- entonces puedes ejecutar los SCRIPTS_SQL_TUTORES_VERIFICACION.sql
-- ========================================
