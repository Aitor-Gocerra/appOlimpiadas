-- =====================================================
-- SCRIPT DE CREACIÓN DE USUARIOS EN LOCAL
-- Base de datos: olimpiadas
-- =====================================================
-- Este script crea 3 usuarios con permisos mínimos según el principio de privilegio mínimo
-- Cada usuario tiene solo los permisos necesarios para realizar sus funciones específicas

-- =====================================================
-- 1. USUARIO APP_READ (Solo Lectura)
-- =====================================================
-- FUNCIÓN: Este usuario se utiliza para las consultas de administrador (procesos 4, 5, 6)
-- PERMISOS: SELECT únicamente
-- MOTIVO: Las consultas administrativas solo necesitan leer datos, no modificarlos.
--         Esto evita modificaciones accidentales o maliciosas a la base de datos.

-- Eliminar el usuario si ya existe (para poder re-ejecutar el script)
DROP USER IF EXISTS 'app_read'@'localhost';

-- Crear usuario con contraseña segura
CREATE USER 'app_read'@'localhost' IDENTIFIED BY 'leer_olimpiadas_2026';

-- Otorgar SOLO permiso de SELECT en todas las tablas de la base de datos olimpiadas
GRANT SELECT ON olimpiadas.* TO 'app_read'@'localhost';

-- EXPLICACIÓN DETALLADA DE PERMISOS:
-- SELECT: Permite leer datos de las tablas para:
--   - Proceso 4 (Deportes_Usuarios): JOIN entre Usuarios, Deportes y Usuarios_deportes
--   - Proceso 5 (Total_Deportes): COUNT de deportes con inscripciones
--   - Proceso 6 (Deportes): GROUP BY para contar usuarios por deporte
--
-- NO se otorgan: INSERT, UPDATE, DELETE, CREATE, DROP, ALTER
-- MOTIVO: Las consultas administrativas nunca necesitan modificar datos


-- =====================================================
-- 2. USUARIO APP_WRITE (Lectura y Escritura)
-- =====================================================
-- FUNCIÓN: Este usuario gestiona el proceso de registro de nuevos usuarios (proceso 2)
-- PERMISOS: SELECT e INSERT únicamente
-- MOTIVO: El registro necesita:
--         - SELECT para validar username único y cargar lista de deportes
--         - INSERT para añadir nuevos usuarios y sus deportes
--         No necesita UPDATE ni DELETE ya que el proceso solo crea registros

-- Eliminar el usuario si ya existe
DROP USER IF EXISTS 'app_write'@'localhost';

-- Crear usuario con contraseña segura
CREATE USER 'app_write'@'localhost' IDENTIFIED BY 'escribir_olimpiadas_2026';

-- Otorgar permisos SELECT e INSERT en todas las tablas de olimpiadas
GRANT SELECT, INSERT ON olimpiadas.* TO 'app_write'@'localhost';

-- EXPLICACIÓN DETALLADA DE PERMISOS:
-- SELECT: Necesario para:
--   - Validar que el nombreUsuario no existe (consulta UNIQUE)
--   - Cargar la lista de deportes disponibles para mostrar en el formulario
--   - Verificar credenciales en el login (proceso 3)
--
-- INSERT: Necesario para:
--   - Insertar nuevo usuario en tabla Usuarios con perfil 'u'
--   - Insertar relaciones en tabla Usuarios_deportes (un INSERT por cada deporte seleccionado)
--
-- NO se otorgan: UPDATE, DELETE, CREATE, DROP, ALTER
-- MOTIVO: El proceso de registro solo crea nuevos datos, nunca modifica ni elimina
--         UPDATE y DELETE se reservan para funciones administrativas futuras


-- =====================================================
-- 3. USUARIO APP_ADMIN (Permisos Completos)
-- =====================================================
-- FUNCIÓN: Usuario para desarrollo, mantenimiento y operaciones administrativas
-- PERMISOS: ALL PRIVILEGES (todos los permisos)
-- MOTIVO: Necesario para:
--         - Desarrollo y pruebas
--         - Mantenimiento de la base de datos
--         - Operaciones futuras como actualizar/eliminar usuarios o deportes
--         - Backup y restauración

-- Eliminar el usuario si ya existe
DROP USER IF EXISTS 'app_admin'@'localhost';

-- Crear usuario con contraseña segura
CREATE USER 'app_admin'@'localhost' IDENTIFIED BY 'admin_olimpiadas_2026';

-- Otorgar TODOS los permisos en la base de datos olimpiadas
GRANT ALL PRIVILEGES ON olimpiadas.* TO 'app_admin'@'localhost';

-- EXPLICACIÓN DETALLADA DE PERMISOS:
-- ALL PRIVILEGES incluye: SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, INDEX, etc.
--
-- MOTIVO DE CADA PERMISO:
-- - SELECT, INSERT, UPDATE, DELETE: CRUD completo para cualquier tabla
-- - CREATE, DROP, ALTER: Modificar estructura de tablas (añadir campos, crear índices)
-- - INDEX: Optimización de consultas
-- - GRANT: Gestionar permisos de otros usuarios (administración delegada)
--
-- IMPORTANTE: Este usuario NO debe usarse en la aplicación en producción
--             Solo para tareas administrativas y desarrollo


-- =====================================================
-- APLICAR CAMBIOS
-- =====================================================
-- Refrescar los privilegios para que los cambios surtan efecto inmediatamente
FLUSH PRIVILEGES;

-- =====================================================
-- VERIFICACIÓN DE PERMISOS
-- =====================================================
-- Para verificar que los permisos se han aplicado correctamente, ejecutar:
-- SHOW GRANTS FOR 'app_read'@'localhost';
-- SHOW GRANTS FOR 'app_write'@'localhost';
-- SHOW GRANTS FOR 'app_admin'@'localhost';

-- =====================================================
-- USO EN LA APLICACIÓN
-- =====================================================
-- En configDB.php se debe configurar el usuario adecuado según el proceso:
-- - Consultas de administrador (procesos 4, 5, 6): usar 'app_read'
-- - Registro de usuarios (proceso 2): usar 'app_write'
-- - Login (proceso 3): usar 'app_write' (necesita SELECT para validar)
-- - Desarrollo/mantenimiento: usar 'app_admin'
