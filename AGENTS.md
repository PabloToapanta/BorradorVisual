# Guía para los módulos PHP

Este repositorio contiene la versión web del sistema de control de acceso. Mantener el código sencillo y seguir el módulo de estudiantes como ejemplo.

## Estructura

- Usar `conexion.php` para abrir la conexión MySQL con MySQLi.
- Crear un modelo PHP por entidad en `modelos/` y un controlador PHP en `controladores/`.
- Poner las vistas de cada entidad en `vistas/<entidad>/`. Separar el listado y registro de la edición en `listar.php` y `editar.php` cuando exista edición.
- Conservar los nombres de las tablas y columnas de `SistemaEstudiantil.sql`.

## Modelos

- Usar el estilo orientado a objetos de MySQLi: `prepare()`, `bind_param()`, `execute()`, `get_result()` y `fetch_assoc()` según corresponda.
- En los listados por ID, seguir `EstudianteModelo::listar(int $id)`: con `0` consultar todos; con otro ID consultar solo ese registro. Devolver el objeto `mysqli_result` y dejar que el controlador lea las filas.
- Cuando una consulta necesite dos tablas, usar `FROM tabla1 a, tabla2 b WHERE a.id = b.id_relacionado` como en `TarjetaModelo`; no usar la palabra `JOIN`.
- No añadir llamadas a `close()` para sentencias, resultados o conexiones.
- Evitar clases base, capas adicionales y funciones genéricas que oculten la consulta SQL.

## Controladores

- Leer formularios con `$_POST['campo'] ?? valor` y parámetros de consulta con `$_GET['campo'] ?? valor`. No usar `$_SERVER` para decidir las acciones.
- Mantener un flujo directo como en `controladores/estudiantes.php`: procesar la acción, consultar los datos y cargar la vista.
- Añadir comentarios breves en los controladores para explicar cada bloque principal.
- No agregar comprobaciones de tipo o longitud como `is_string()`, `ctype_digit()` o `mb_strlen()` salvo que se acuerde para ese módulo.

## Vistas

- Usar HTML y PHP sin JavaScript ni CSS por ahora.
- Escribir los `if` con llaves: `<?php if (condición) { ?> ... <?php } ?>`.
- Al mostrar texto de la base o del formulario, usar `htmlspecialchars($valor)`.
- Mantener formularios y enlaces sencillos, como en `vistas/estudiantes/`.

## Trabajo en Git

- Crear una rama `feature/<modulo>` por Issue, a partir de `develop`.
- Enviar los cambios mediante un pull request hacia `develop`. Reservar `main` para la versión estable.
