# 📚 Sistema de Gestión de Biblioteca

Un sistema completo de gestión bibliotecaria desarrollado en **Laravel 12** que permite administrar libros, usuarios y préstamos de manera eficiente y profesional.

## 🚀 Características Principales

### 📖 Gestión de Libros
- ✅ CRUD completo de libros (Crear, Leer, Actualizar, Eliminar)
- ✅ Control automático de inventario y disponibilidad
- ✅ Búsqueda por título, autor, género e ISBN
- ✅ Gestión de múltiples copias por libro
- ✅ Validación de eliminación (no permite eliminar libros con préstamos activos)

### 👥 Gestión de Usuarios
- ✅ Registro y administración de usuarios
- ✅ Sistema de activación/desactivación de usuarios
- ✅ Historial completo de préstamos por usuario
- ✅ Límite de 3 préstamos activos simultáneos
- ✅ Validación para usuarios con préstamos vencidos

### 📋 Sistema de Préstamos
- ✅ Creación y gestión de préstamos
- ✅ Cálculo automático de fechas de devolución
- ✅ Control de préstamos vencidos
- ✅ Proceso de devolución con observaciones
- ✅ Actualización automática de disponibilidad de libros

### 📊 Estadísticas y Reportes
- ✅ Dashboard con resumen general del sistema
- ✅ Libros más prestados (Top 10)
- ✅ Usuarios más activos
- ✅ Estadísticas de préstamos por mes
- ✅ Géneros literarios más populares

## 🛠️ Tecnologías Utilizadas

- **Backend:** Laravel 12 (PHP 8.2+)
- **Base de Datos:** MySQL/PostgreSQL/SQLite
- **Autenticación:** Laravel Sanctum
- **Testing:** PHPUnit
- **API:** RESTful API con JSON responses

## 📋 Requisitos del Sistema

- PHP >= 8.2
- Composer
- MySQL >= 8.0 / PostgreSQL >= 12 / SQLite >= 3.35
- Node.js >= 16.x (opcional, para frontend)

## ⚙️ Instalación

### 1. Clonar el repositorio
```bash
git clone [URL_DEL_REPOSITORIO]
cd sistema-biblioteca
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar el entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar base de datos
Edita el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Ejecutar migraciones y seeders
```bash
# Ejecutar migraciones
php artisan migrate

# Poblar la base de datos con datos de ejemplo
php artisan db:seed
```

### 6. Iniciar el servidor
```bash
php artisan serve
```

El sistema estará disponible en `http://localhost:8000`

## 📚 Estructura de la Base de Datos

### Tabla: libros
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BigInt | Identificador único |
| titulo | String | Título del libro |
| autor | String | Autor del libro |
| genero | String | Género literario |
| descripcion | Text | Descripción del libro |
| isbn | String | ISBN único |
| cantidad_total | Integer | Cantidad total de copias |
| cantidad_disponible | Integer | Copias disponibles |

### Tabla: usuarios
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BigInt | Identificador único |
| nombre | String | Nombre completo |
| email | String | Email único |
| telefono | String | Número de teléfono |
| direccion | String | Dirección del usuario |
| activo | Boolean | Estado del usuario |

### Tabla: prestamos
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BigInt | Identificador único |
| usuario_id | BigInt | FK a usuarios |
| libro_id | BigInt | FK a libros |
| fecha_prestamo | Date | Fecha del préstamo |
| fecha_devolucion_esperada | Date | Fecha límite de devolución |
| fecha_devolucion_real | Date | Fecha real de devolución |
| estado | Enum | Estado: activo, devuelto, vencido |
| observaciones | Text | Notas adicionales |

## 🔌 API Endpoints

### 📖 Libros
```http
GET    /api/libros              # Listar todos los libros
POST   /api/libros              # Crear nuevo libro
GET    /api/libros/{id}         # Obtener libro específico
PUT    /api/libros/{id}         # Actualizar libro
DELETE /api/libros/{id}         # Eliminar libro
```

### 👥 Usuarios
```http
GET    /api/usuarios            # Listar todos los usuarios
POST   /api/usuarios            # Crear nuevo usuario
GET    /api/usuarios/{id}       # Obtener usuario específico
PUT    /api/usuarios/{id}       # Actualizar usuario
DELETE /api/usuarios/{id}       # Eliminar usuario
```

### 📋 Préstamos
```http
GET    /api/prestamos           # Listar todos los préstamos
POST   /api/prestamos           # Crear nuevo préstamo
GET    /api/prestamos/{id}      # Obtener préstamo específico
PUT    /api/prestamos/{id}      # Actualizar préstamo
DELETE /api/prestamos/{id}      # Eliminar préstamo
PUT    /api/prestamos/{id}/devolver  # Devolver libro
```

### 📊 Estadísticas
```http
GET    /api/estadisticas/resumen                # Resumen general
GET    /api/estadisticas/libros-mas-prestados   # Top libros
GET    /api/estadisticas/usuarios-mas-activos   # Top usuarios
GET    /api/estadisticas/prestamos-por-mes      # Estadísticas mensuales
GET    /api/estadisticas/generos-populares      # Géneros populares
```

## 📝 Ejemplos de Uso

### Crear un nuevo libro
```http
POST /api/libros
Content-Type: application/json

{
    "titulo": "El Quijote",
    "autor": "Miguel de Cervantes",
    "genero": "Clásico",
    "descripcion": "La historia del ingenioso hidalgo",
    "isbn": "978-8424116231",
    "cantidad_total": 3
}
```

### Crear un préstamo
```http
POST /api/prestamos
Content-Type: application/json

{
    "usuario_id": 1,
    "libro_id": 1,
    "fecha_prestamo": "2025-01-15",
    "dias_prestamo": 14,
    "observaciones": "Préstamo para proyecto escolar"
}
```

### Devolver un libro
```http
PUT /api/prestamos/1/devolver
Content-Type: application/json

{
    "observaciones": "Libro devuelto en perfecto estado"
}
```

## 🧪 Testing

El proyecto incluye tests unitarios y de integración:

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter LibroTest

# Ejecutar tests con coverage
php artisan test --coverage
```

### Tests Incluidos
- ✅ Creación, lectura, actualización y eliminación de libros
- ✅ Validación de campos requeridos
- ✅ Lógica de negocio para préstamos
- ✅ Gestión de inventario automática

## 🔒 Reglas de Negocio

### Préstamos
- Un usuario activo puede tener máximo **3 préstamos simultáneos**
- No se pueden crear préstamos para usuarios con **préstamos vencidos**
- No se pueden crear préstamos si el libro **no está disponible**
- Los préstamos tienen una duración máxima de **30 días**

### Usuarios
- Los usuarios inactivos **no pueden realizar préstamos**
- No se puede eliminar un usuario con **préstamos activos**
- El email debe ser **único** en el sistema

### Libros
- No se puede eliminar un libro con **préstamos activos**
- La cantidad disponible se actualiza **automáticamente**
- El ISBN debe ser **único** cuando se proporciona

## 📊 Datos de Ejemplo

El sistema incluye seeders con datos de prueba:
- **6 libros** de diferentes géneros y autores
- **5 usuarios** con diferentes estados
- Datos realistas para testing y demostración



---

