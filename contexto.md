Prueba Técnica
Se requiere implementar un nuevo módulo para que los agentes de soporte puedan dejar notas internas sobre los jugadores.

Objetivo
Desarrollar un módulo de "Historial de Notas de Jugador" (Player Notes) que permita visualizar y crear observaciones sobre un usuario específico, respetando la arquitectura de repositorios y componentes Livewire del proyecto.

Requerimientos Técnicos
- Bases de Datos (Migraciones y Modelos)
- Crear tabla correspondientes
- Definir relaciones entre los modelos
- Capa de Lógica (Patron Repositorio)
- Implementar los métodos correspondientes.
- Frontend (Livewire)
- Componente que liste: Fecha, Autor (Nombre del User) y contenido de la nota.
- Incluir un formulario simple para agregar una nota
- Validar que el campo nota no esté vacío y tenga un máximo de caracteres.
- Al guardar, la tabla debe refrescarse automáticamente sin recargar la página.
- Permisos: El botón/formulario de ‘Agregar Nota’ solo debe ser visible si el usuario tiene el permiso correspondiente.

Qué evaluaremos
- Arquitectura: Respetar patrón Repositorio, uso de principios SOLID.
- Laravel Moderno: Uso de características PHP 8+, Type Hinting, Return Types, Laravel 9+.
- Livewire: Manejo correcto del estado ($rules, renders, emit/listeners).
- Limpieza: Código legible, nombres de variables descriptivos en inglés.
- Bonus: Si se incluye un pequeño Test (Feature Test) para verificar que una nota se guarda correctamente en base de datos.

Entregable
Enlace a repositorio público (GitHub, GitLab, Bitbucket)