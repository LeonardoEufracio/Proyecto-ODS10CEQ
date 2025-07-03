DELIMITER //

-- 1. Procedimiento para registrar un nuevo alumno
CREATE PROCEDURE sp_registrar_alumno(
    IN p_dni VARCHAR(10),
    IN p_nombres VARCHAR(100),
    IN p_apellido_paterno VARCHAR(100),
    IN p_apellido_materno VARCHAR(100),
    IN p_provincia VARCHAR(50),
    IN p_correo VARCHAR(100),
    IN p_celular VARCHAR(15),
    IN p_password VARCHAR(255)
BEGIN
    INSERT INTO alumnos (dni, nombres, apellido_paterno, apellido_materno, provincia, correo, celular, password)
    VALUES (p_dni, p_nombres, p_apellido_paterno, p_apellido_materno, p_provincia, p_correo, p_celular, p_password);
END //

-- 2. Procedimiento para matricular un alumno en un curso
CREATE PROCEDURE sp_matricular_alumno(
    IN p_id_alumno INT,
    IN p_id_curso INT,
    IN p_desea_certificado TINYINT)
BEGIN
    INSERT INTO matriculas (id_alumno, id_curso, desea_certificado)
    VALUES (p_id_alumno, p_id_curso, p_desea_certificado);
END //

-- 3. Procedimiento para obtener los cursos de un alumno
CREATE PROCEDURE sp_obtener_cursos_alumno(IN p_id_alumno INT)
BEGIN
    SELECT c.id, c.nombre, c.categoria, c.dias, c.fecha_inicio, c.horario, 
           m.fecha_matricula, m.desea_certificado
    FROM cursos c
    JOIN matriculas m ON c.id = m.id_curso
    WHERE m.id_alumno = p_id_alumno
    ORDER BY c.fecha_inicio;
END //

-- 4. Procedimiento para buscar cursos por categoría
CREATE PROCEDURE sp_buscar_cursos_por_categoria(IN p_categoria VARCHAR(50))
BEGIN
    SELECT id, nombre, dias, fecha_inicio, horario, certificado_disponible
    FROM cursos
    WHERE categoria = p_categoria
    ORDER BY fecha_inicio;
END //

-- 5. Procedimiento para actualizar información de alumno
CREATE PROCEDURE sp_actualizar_alumno(
    IN p_id INT,
    IN p_dni VARCHAR(10),
    IN p_nombres VARCHAR(100),
    IN p_apellido_paterno VARCHAR(100),
    IN p_apellido_materno VARCHAR(100),
    IN p_provincia VARCHAR(50),
    IN p_correo VARCHAR(100),
    IN p_celular VARCHAR(15))
BEGIN
    UPDATE alumnos
    SET dni = p_dni,
        nombres = p_nombres,
        apellido_paterno = p_apellido_paterno,
        apellido_materno = p_apellido_materno,
        provincia = p_provincia,
        correo = p_correo,
        celular = p_celular
    WHERE id = p_id;
END //

-- 6. Procedimiento para verificar credenciales de alumno
CREATE PROCEDURE sp_verificar_login_alumno(
    IN p_correo VARCHAR(100),
    IN p_password VARCHAR(255))
BEGIN
    SELECT id, dni, nombres, apellido_paterno, apellido_materno, provincia, correo, celular
    FROM alumnos
    WHERE correo = p_correo AND password = p_password;
END //

-- 7. Procedimiento para obtener estadísticas de matriculas
CREATE PROCEDURE sp_obtener_estadisticas_matriculas()
BEGIN
    -- Cursos más populares
    SELECT c.nombre, COUNT(m.id) as total_matriculas
    FROM cursos c
    LEFT JOIN matriculas m ON c.id = m.id_curso
    GROUP BY c.id
    ORDER BY total_matriculas DESC
    LIMIT 10;
    
    -- Matriculas por categoría
    SELECT c.categoria, COUNT(m.id) as total_matriculas
    FROM cursos c
    LEFT JOIN matriculas m ON c.id = m.id_curso
    GROUP BY c.categoria
    ORDER BY total_matriculas DESC;
END //

-- 8. Procedimiento para obtener todos los cursos disponibles
CREATE PROCEDURE sp_obtener_todos_cursos()
BEGIN
    SELECT id, nombre, categoria, dias, fecha_inicio, horario, certificado_disponible
    FROM cursos
    ORDER BY fecha_inicio;
END //

-- 9. Procedimiento para cancelar matrícula de un curso
CREATE PROCEDURE sp_cancelar_matricula(
    IN p_id_alumno INT,
    IN p_id_curso INT)
BEGIN
    DELETE FROM matriculas 
    WHERE id_alumno = p_id_alumno AND id_curso = p_id_curso;
END //

-- 10. Procedimiento para cambiar contraseña de alumno
CREATE PROCEDURE sp_cambiar_password(
    IN p_id_alumno INT,
    IN p_nueva_password VARCHAR(255))
BEGIN
    UPDATE alumnos
    SET password = p_nueva_password
    WHERE id = p_id_alumno;
END //

DELIMITER ;
