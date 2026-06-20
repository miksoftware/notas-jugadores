# Notas de Jugadores

Módulo de historial de notas internas sobre jugadores. Los agentes de soporte pueden registrar y consultar observaciones por jugador.

**Stack:** PHP 8.3 · Laravel 13 · Livewire 4 · Spatie Permission · Tailwind CSS 4

---

## Requisitos

- PHP >= 8.3
- Composer
- Node.js >= 18
- MySQL (recomendado) o SQLite

---

## Instalación

```bash
# 1. Clonar e instalar dependencias
git clone <url-del-repositorio> notas-jugadores
cd notas-jugadores
composer install
npm install

# 2. Entorno
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate

# 3. Configurar base de datos en .env
# MySQL (recomendado):
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notas_jugadores
DB_USERNAME=root
DB_PASSWORD=

# SQLite (alternativa, sin configuración extra):
# DB_CONNECTION=sqlite

# 4. Migrar y sembrar
php artisan migrate
php artisan db:seed

# 5. Compilar assets y levantar servidor
npm run build
php artisan serve
```

Aplicación disponible en [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Credenciales por defecto

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@admin.com` | `123admin` | Admin |

---

## Tests

```bash
php artisan test
```

> Los tests usan SQLite en memoria y no afectan la base de datos de desarrollo.
