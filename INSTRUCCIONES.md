# SilverGym - Sistema de Gestión de Gimnasio

Sistema completo para la gestión de gimnasios desarrollado con Laravel 11.

## 🏋️ Características

- ✅ **Sistema de Autenticación Seguro**
  - Inicio de sesión con usuario y contraseña
  - Cambio obligatorio de contraseña en primer inicio
  - Validación de contraseñas seguras
  - Control de usuarios activos/inactivos

- 👥 **Gestión de Usuarios**
  - Roles: Administrador y Staff
  - Control de permisos
  - CRUD completo de usuarios

- 💳 **Gestión de Membresías**
  - Crear diferentes tipos de membresías
  - Configuración de precios y duración
  - Estado activo/inactivo

- 🧑 **Gestión de Miembros**
  - Registro completo de información personal
  - Fotografía del miembro
  - Búsqueda avanzada
  - Control de estado

- 🎫 **Generación de Credenciales**
  - Credencial digital con foto
  - Información de membresía
  - Imprimible

- 💰 **Registro de Pagos**
  - Múltiples métodos de pago
  - Control automático de vencimientos
  - Historial completo

- 📊 **Control de Visitas**
  - Registro de entradas y salidas
  - Validación de membresía activa
  - Control de duración de estadía
  - Reporte diario

- 📈 **Dashboard**
  - Estadísticas en tiempo real
  - Miembros activos/inactivos
  - Visitas del día
  - Ingresos diarios
  - Próximos vencimientos

## 📋 Requisitos

- PHP >= 8.2
- Composer
- MySQL o PostgreSQL
- Node.js y NPM (opcional, para compilar assets)

## 🚀 Instalación

### 1. Clonar o descargar el proyecto

```bash
cd c:\Users\Personal\Desktop\silvergym\proyecto
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Configurar el archivo .env

```bash
cp .env.example .env
```

Editar el archivo `.env` y configurar la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=silvergym
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos

Crear una base de datos llamada `silvergym` en MySQL/PostgreSQL.

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

### 7. Ejecutar los seeders (datos iniciales)

```bash
php artisan db:seed
```

Esto creará:
- Usuario administrador: `admin` / `admin123`
- Usuario staff: `staff` / `staff123`
- 3 membresías predeterminadas (Mensual, Trimestral, Anual)

⚠️ **Importante**: Ambos usuarios deberán cambiar su contraseña en el primer inicio de sesión.

### 8. Crear el enlace simbólico para las imágenes

```bash
php artisan storage:link
```

### 9. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

## 👤 Usuarios por Defecto

### Administrador
- **Usuario**: `admin`
- **Contraseña**: `admin123`
- Acceso completo al sistema

### Staff
- **Usuario**: `staff`
- **Contraseña**: `staff123`
- Acceso limitado (sin gestión de usuarios)

## 📁 Estructura del Proyecto

```
proyecto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── MembresiaController.php
│   │   │   ├── MiembroController.php
│   │   │   ├── PagoController.php
│   │   │   └── VisitaController.php
│   │   └── Middleware/
│   │       └── CheckMustChangePassword.php
│   └── Models/
│       ├── User.php
│       ├── Membresia.php
│       ├── Miembro.php
│       ├── Pago.php
│       └── Visita.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── change-password.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       ├── usuarios/
│       ├── membresias/
│       ├── miembros/
│       ├── pagos/
│       └── visitas/
└── routes/
    └── web.php
```

## 🔧 Funcionalidades Principales

### Inicio de Sesión
1. Acceder a `http://localhost:8000`
2. Ingresar usuario y contraseña
3. Si es la primera vez, cambiar la contraseña
4. Acceso al dashboard

### Registrar un Miembro
1. Ir a "Miembros" > "Nuevo Miembro"
2. Completar la información personal
3. Opcional: Subir foto
4. Guardar

### Registrar un Pago
1. Ir a "Pagos" > "Registrar Pago"
2. Seleccionar miembro
3. Seleccionar membresía (precio se autocompleta)
4. Seleccionar método de pago
5. Guardar (el vencimiento se calcula automáticamente)

### Registrar Visita
1. Ir a "Visitas" > "Registrar Entrada"
2. Seleccionar miembro (solo con membresía activa)
3. La entrada se registra con hora actual
4. Al salir, presionar "Registrar Salida"

### Generar Credencial
1. Ir a "Miembros"
2. Seleccionar un miembro
3. Click en "Credencial"
4. Imprimir o guardar como PDF

## 🔒 Seguridad

- Contraseñas encriptadas con bcrypt
- Validación de contraseñas seguras (mínimo 8 caracteres, mayúsculas y números)
- Cambio obligatorio de contraseña en primer inicio
- Control de sesiones
- Protección CSRF
- Validación de datos en servidor

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Base de Datos**: MySQL/PostgreSQL
- **Frontend**: Blade Templates + CSS personalizado
- **Autenticación**: Laravel Auth
- **PHP**: 8.2+

## 📝 Notas

- Las imágenes de los miembros se guardan en `storage/app/public/miembros/`
- Los vencimientos de membresías se calculan automáticamente según la duración configurada
- Solo miembros con membresía activa pueden registrar visitas
- El sistema valida que no haya visitas abiertas duplicadas

## 🐛 Solución de Problemas

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1045] Access denied"
Verificar las credenciales en el archivo `.env`

### Las imágenes no se muestran
```bash
php artisan storage:link
```

### Error 404 en rutas
```bash
php artisan route:clear
php artisan cache:clear
```

## 📞 Soporte

Para cualquier duda o problema, revisar:
1. Los logs en `storage/logs/laravel.log`
2. La configuración en `.env`
3. Los permisos de las carpetas `storage/` y `bootstrap/cache/`

---

**Desarrollado para SilverGym** 🏋️💪
