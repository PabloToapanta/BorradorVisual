# Sistema de control de acceso en PHP

Versión web del proyecto Java Swing. Se desarrollará por etapas con PHP, MySQL y un MVC sencillo.

## Estructura

- `conexion.php`: abre la conexión MySQL mediante MySQLi.
- `modelos/`: consultas y operaciones de base de datos.
- `controladores/`: recibe y valida datos de formularios.
- `vistas/estudiantes/listar.php`: registro y listado de estudiantes.
- `vistas/estudiantes/editar.php`: formulario de edición.
- `index.php`: página inicial provisional.
- `SistemaEstudiantil.sql`: esquema original para importar en phpMyAdmin si hace falta.

La base `SistemaEstudiantil` ya existía en MySQL al preparar esta estructura; no se reimportó el SQL para conservar sus datos.

Abrir la página inicial en `http://localhost/estudio/proyecto_final_visual/` cuando Apache esté activo.

## Módulo de estudiantes

Abrir `http://localhost/estudio/proyecto_final_visual/controladores/estudiantes.php` para listar, registrar, editar y desactivar estudiantes. La desactivación conserva al estudiante en la base de datos.
