# eCommerce Laravel - Tienda de Productos Digitales

eCommerce tipo G2A para venta de juegos, suscripciones, keys y productos digitales.

**Estado:** ✅ NIVEL EXPERTO COMPLETADO

---

## 📋 Descripción del Proyecto

Aplicación web de comercio electrónico desarrollada con **Laravel 8**, aplicando la estructura MVC con **Blade** (vistas) y **Eloquent** (ORM). Sistema completo de comercio electrónico con catálogo de productos digitales, carrito de compras, procesamiento de pagos y **sistema de pedidos con generación de keys de activación**.

### Características Implementadas

- ✅ Sistema de categorías y productos
- ✅ Búsqueda y filtrado avanzado
- ✅ Vista de catálogo con paginación
- ✅ Ficha detallada de productos
- ✅ Productos destacados en página principal
- ✅ Diseño responsive (mobile-first)
- ✅ Modo claro/oscuro con persistencia
- ✅ Bootstrap 5.3 + Bootstrap Icons
- ✅ **Sistema de autenticación (Login/Registro)**
- ✅ **Gestión de sesiones de usuario**
- ✅ **Rutas protegidas con middleware**
- ✅ **Carrito de compras completo**
- ✅ **Control de cantidades y stock en tiempo real**
- ✅ **Proceso de checkout con validación de tarjeta**
- ✅ **Sistema de pedidos (orders, order_items)**
- ✅ **Generación automática de keys de activación**
- ✅ **Mystery Keys aleatorias de Steam**
- ✅ **Historial de pedidos del usuario**
- ✅ **Vista detallada de pedidos con keys copiables**
- ✅ **Confirmación de pago por email para compras >100€**
- ✅ **Gestión de imágenes con Storage**
- ✅ **Panel de Administración de Productos**
- ✅ **CRUD completo de productos (crear, leer, editar, eliminar)**
- ✅ **Middleware de autorización para admins**
- ✅ **Modal de confirmación estético para eliminar**
- ✅ **Restricción de compra para administradores**
- ✅ **Transacciones atómicas en BD**

### Estructura MVC

- **Modelos**: Product, Category, User, CartItem, Order, OrderItem, PaymentConfirmation
- **Vistas**: Layout base, Home, Catálogo, Ficha de producto, Categorías, Auth (Login/Registro), Carrito, **Admin (Listar, Crear, Editar productos)**, **Checkout, Pedidos, Historial**
- **Controladores**: HomeController, ProductController, CategoryController, CartController, AuthController, **Admin\ProductController**, **PaymentController, OrderController**

---

## 🎯 Fases del Proyecto

### ✅ NIVEL BÁSICO - COMPLETADO
- ✅ Configuración de Laravel y base de datos
- ✅ Migraciones de `categories` y `products`
- ✅ Modelos Category y Product con relaciones
- ✅ Seeders con datos de prueba (5 categorías, 23 productos)
- ✅ Layout base Blade con modo claro/oscuro
- ✅ Vista de inicio con productos destacados
- ✅ Catálogo completo de productos
- ✅ Vista de ficha individual de producto
- ✅ Filtrado por categorías
- ✅ Sistema de búsqueda
- ✅ **Sistema de autenticación completo**
- ✅ **Middleware de protección de rutas**

### ✅ NIVEL INTERMEDIO - COMPLETADO
- ✅ **Autenticación de usuarios (Login/Registro)**
- ✅ **Gestión de sesiones de usuario**
- ✅ **Carrito de compras completo**
- ✅ **Añadir y eliminar productos del carrito**
- ✅ **Actualizar cantidades de productos**
- ✅ **Vaciar carrito completo**
- ✅ **Cálculo de subtotal y total**
- ✅ **Control de stock en tiempo real**
- ✅ **Validación de cantidades máximas**
- ✅ **Contador de items dinámico**
- ✅ **Gestión de imágenes con Storage Link**

### ✅ NIVEL EXPERTO - COMPLETADO
- ✅ **Panel de Administración de Productos (CREATE, READ, UPDATE, DELETE)**
- ✅ **Autenticación con rol de administrador (is_admin)**
- ✅ **Middleware de protección para rutas admin**
- ✅ **Vistas Admin: Listar, Crear, Editar productos**
- ✅ **Modal de confirmación para eliminar productos**
- ✅ **Generación automática de slug desde nombre**
- ✅ **Validación de imágenes y almacenamiento en Storage**
- ✅ **Restricción de compras para administradores**
- ✅ **Paginación mejorada con Bootstrap Icons**
- ✅ **Sistema de pedidos (orders, order_items)**
- ✅ **Generación automática de keys de activación**
- ✅ **Proceso de checkout completo**
- ✅ **Historial de pedidos**
- ✅ **Confirmación de pago por email**
- Proceso de checkout completo
- Historial de pedidos
- Panel de analytics
=======
### ✅ NIVEL EXPERTO - COMPLETADO
- ✅ **Sistema de pedidos (orders, order_items)**
- ✅ **Proceso de checkout completo con simulación de pago**
- ✅ **Generación automática de keys de activación**
- ✅ **Mystery Keys aleatorias de Steam (20 juegos)**
- ✅ **Historial de pedidos del usuario con paginación**
- ✅ **Vista detallada de pedidos con keys copiables**
- ✅ **Confirmación por email para compras >100€**
- ✅ **Envío de keys por email**
- ✅ **Transacciones atómicas (rollback automático)**
- ✅ **Reducción de stock tras compra**
- ✅ **Número de pedido único generado automáticamente**
- ✅ **Estados de pedido (completed, pending, cancelled)**

### 🔜 FUTURAS MEJORAS
- Panel de administración (CRUD de productos y categorías)
- Integración con pasarela de pago real (Stripe/PayPal)
- Sistema de reseñas y valoraciones
- Wishlist / Lista de deseos
- Cupones de descuento
- Dashboard de analytics para admin
>>>>>>> origin/luis

---

## 💻 Requisitos del Sistema

- **PHP** >= 8.0
- **Composer** 
- **MySQL** (XAMPP recomendado)
- **Git**
- Node.js (opcional, para assets)

---

## 🚀 Instalación y Configuración

### 1️ Clonar el repositorio

```bash
git clone https://github.com/AleGonz2812/eCommerceLaravel.git
cd eCommerceLaravel
```

### 2️ Instalar dependencias de PHP

```bash
composer install
```

**Nota:** Si no tienes Composer instalado, descárgalo desde [getcomposer.org](https://getcomposer.org/)

### 3️ Configurar el archivo de entorno

**En Windows:**
```bash
copy .env.example .env
```

**En Linux/Mac:**
```bash
cp .env.example .env
```

**Luego genera la clave de la aplicación:**
```bash
php artisan key:generate
```

### 4️ Configurar la base de datos

Editar el archivo `.env` y configurar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_laravel
DB_USERNAME=root
DB_PASSWORD=
```


### 5️ Iniciar XAMPP

1. Abrir **XAMPP Control Panel**
2. Iniciar **Apache** ✅
3. Iniciar **MySQL** ✅

### 6 Ejecutar migraciones y seeders

Este comando creará las tablas y llenará la base de datos con datos de prueba:

```bash
php artisan migrate:fresh --seed
```

**Resultado esperado:**
- ✅ 5 categorías creadas
- ✅ 23 productos creados
- ✅ Tablas: users, categories, products, cart_items, orders, order_items, payment_confirmations, failed_jobs, password_resets, personal_access_tokens

### 8️ Crear enlace simbólico para imágenes

```bash
php artisan storage:link
```

Este comando crea un enlace entre `storage/app/public` y `public/storage` para que las imágenes sean accesibles desde el navegador.

### 9️ Agregar las imágenes del proyecto

Coloca las imágenes en las siguientes rutas:

**Categorías (5 imágenes):**
```
storage/app/public/categories/
├── videojuegos.jpg
├── suscripciones.jpg
├── tarjetas-gaming.jpg
├── mystery-keys.jpg
└── software.jpg
```

**Productos (23 imágenes):**
```
storage/app/public/products/
├── cyberpunk-2077.jpg
├── elden-ring.jpg
├── rdr2.jpg
├── ... (20 más)
```

**Resoluciones recomendadas:**
- Categorías: 1024x339px
- Productos: 800x1200px


### 10 Iniciar el servidor de desarrollo

```bash
php artisan serve
```

**✅ El proyecto estará disponible en:** [http://localhost:8000]

---

## 📂 Estructura del Proyecto

```
eCommerceLaravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php          # Página de inicio
│   │   │   ├── ProductController.php       # Listado, búsqueda, detalle
│   │   │   ├── CategoryController.php      # Filtrado por categoría
│   │   │   ├── AuthController.php          # Login, Registro, Logout
│   │   │   ├── CartController.php          # Carrito completo
<<<<<<< HEAD
│   │   │   └── Admin/
│   │   │       └── ProductController.php   # CRUD de productos (admin)
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php                 # Verifica rol de administrador
=======
│   │   │   ├── PaymentController.php       # Checkout y procesamiento de pagos
│   │   │   └── OrderController.php         # Historial y detalle de pedidos
>>>>>>> origin/luis
│   │   └── ViewComposers/
│   │       └── NavigationComposer.php      # Comparte categorías globalmente
│   ├── Models/
│   │   ├── Category.php                    # Modelo de categorías
│   │   ├── Order.php                       # Modelo de pedidos
│   │   ├── OrderItem.php                   # Modelo de items de pedidos
│   │   ├── PaymentConfirmation.php         # Modelo de confirmaciones de pago
│   │   ├── Product.php                     # Modelo de productos
│   │   ├── CartItem.php                    # Modelo de items del carrito
│   │   └── User.php                        # Modelo de usuarios (con is_admin)
│   └── Providers/
│       └── AppServiceProvider.php          # Registro de ViewComposer
├── database/
│   ├── migrations/
│   │   ├── create_cart_items_table.php     # Tabla de carrito
│   │   ├── create_orders_table.php         # Tabla de pedidos
│   │   ├── create_order_items_table.php    # Tabla de items de pedidos
│   │   └── create_payment_confirmations_table.php  # Confirmaciones >100€s
│   │   ├── create_categories_table.php
│   │   ├── create_products_table.php
│   │   └── create_cart_items_table.php     # Tabla de carrito
│   └── seeders/
│       ├── CategorySeeder.php              # 5 categorías
│       └── ProductSeeder.php               # 23 productos
├── public/
│   └── css/
│       └── app.css                         # Estilos personalizados
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Layout maestro
│       ├── partials/
│       │   ├── header.blade.php            # Cabecera
│       │   ├── navbar.blade.php            # Navegación
│       │   └ayments/
│       │   ├── checkout.blade.php          # Formulario de pago
│       │   ├── success.blade.php           # Pago exitoso
│       │   ├── pending.blade.php           # Pendiente de confirmación
│       │   └── confirm.blade.php           # Confirmación de pago
│       ├── orders/
│       │   ├── index.blade.php             # Historial de pedidos
│       │   └── show.blade.php              # Detalle de pedido con keys
│       ├── p── footer.blade.php            # Pie de página
│       ├── auth/
│       │   ├── login.blade.php             # Formulario de login
│       │   └── register.blade.php          # Formulario de registro
│       ├── admin/
│       │   └── products/
│       │       ├── index.blade.php         # Listar productos (tabla)
│       │       ├── create.blade.php        # Formulario crear producto
│       │       └── edit.blade.php          # Formulario editar producto
│       ├── cart/
│       │   └── index.blade.php             # Vista del carrito
│       ├── products/
│       │   ├── index.blade.php             # Catálogo
│       │   └── show.blade.php              # Ficha de producto
│       ├── category/
│       │   └── show.blade.php              # Productos por categoría
│       ├── vendor/
│       │   └── pagination/
│       │       └── bootstrap-5.blade.php   # Paginación personalizada
│       └── home.blade.php                  # Página de inicio
├── routes/
│   └── web.php                             # Rutas web
└── storage/
    └── app/
        └── public/                         # Almacenamiento de imágenes
            ├── categories/
            └── products/
```

---

## 🗄️ Esquema de Base de Datos

### Tabla: `categories`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Clave primaria |
| name | VARCHAR(255) | Nombre de la categoría |
| slug | VARCHAR(255) | URL amigable (único) |
| image | VARCHAR(255) | Ruta de la imagen |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

### Tabla: `products`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Clave primaria |
| category_id | BIGINT | FK a categories |
| name | VARCHAR(255) | Nombre del producto |
| slug | VARCHAR(255) | URL amigable (único) |
| description | TEXT | Descripción del producto |
| price | DECIMAL(10,2) | Precio |
| image | VARCHAR(255) | Ruta de la imagen |
| stock | INTEGER | Unidades disponibles |
| featured | BOOLEAN | Si es destacado |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

### Tabla: `cart_items`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Clave primaria |
| user_id | BIGINT | FK a users |
| product_id | BIGINT | FK a products |
| quantity | INTEGER | Cantidad de unidades |
| price | DECIMAL(10,2) | Precio al agregar al carrito |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

**Relaciones:**
- `categories` → `products` (1:N)
- `users` → `cart_items` (1:N)
- `products` → `cart_items` (1:N)
- **Índice único:** `user_id` + `product_id` (un usuario no puede tener el mismo producto duplicado)

---

## 🛣️ Rutas Disponibles

| Ruta | Método | Descripción |
|------|--------|-------------|
| `/` | GET | Página de inicio con productos destacados |
| `/products` | GET | Catálogo completo de productos (paginado) |
| `/products/search?q={query}` | GET | Búsqueda de productos |
| `/products/{slug}` | GET | Ficha detallada de un producto |
| `/category/{slug}` | GET | Productos filtrados por categoría |
| `/register` | GET/POST | Formulario y proceso de registro |
| `/login` | GET/POST | Formulario y proceso de login |
| `/logout` | POST | Cerrar sesión (requiere auth) |
| `/cart` | GET | Ver carrito de compras (requiere auth) |
| `/cart/add/{product}` | POST | Añadir producto al carrito (requiere auth) |
| `/cart/update/{cartItem}` | PATCH | Actualizar cantidad de producto (requiere auth) |
| `/cart/remove/{cartItem}` | DELETE | Eliminar producto del carrito (requiere auth) |
| `/cart/clear` | DELETE | Vaciar todo el carrito (requiere auth) |
| `/admin/products` | GET | Listar productos (requiere admin) |
| `/admin/products/create` | GET | Formulario crear producto (requiere admin) |
| `/admin/products` | POST | Guardar nuevo producto (requiere admin) |
| `/admin/products/{id}/edit` | GET | Formulario editar producto (requiere admin) |
| `/admin/products/{id}` | PUT | Actualizar producto (requiere admin) |
| `/admin/products/{id}` | DELETE | Eliminar producto (requiere admin) |

---

## 🎨 Características de la Interfaz

### Diseño Responsive
- ✅ Mobile-first con Bootstrap 5.3
- ✅ Grid adaptativo (12 columnas)
- ✅ Navegación colapsable en móviles

### Modo Claro/Oscuro
- ✅ Toggle en el header
- ✅ Persistencia con localStorage
- ✅ Iconos dinámicos (sol/luna)

### Sistema de Autenticación
- ✅ Formularios de login y registro con validación
- ✅ Mensajes flash de éxito/error
- ✅ Dropdown de usuario en navbar y header
- ✅ Opción "Recordarme" en login
- ✅ Protección de rutas con middleware
- ✅ Logout seguro con token CSRF

### Componentes
- ✅ Cards de productos con hover effect
- ✅ Badges de categoría y destacados
- ✅ Sistema de paginación
- ✅ Breadcrumbs en ficha de producto
- ✅ Indicadores de stock (disponible/agotado)
- ✅ Dropdowns de usuario autenticado
- ✅ Alertas dismissibles

---

## 🔐 Sistema de Autenticación

### Características Implementadas

**Registro de Usuarios:**
- Validación de datos (nombre, email único, contraseña mínimo 8 caracteres)
- Confirmación de contraseña
- Hash seguro de contraseñas con bcrypt
- Login automático después del registro
- Mensajes de feedback al usuario

**Login:**
- Validación de credenciales
- Opción "Recordarme" para sesiones persistentes
- Regeneración de sesión por seguridad
- Redirección inteligente a página anterior
- Mensajes de error personalizados

**Gestión de Sesión:**
- Dropdown con nombre de usuario en navbar
- Dropdown con opciones en header
- Logout seguro con invalidación de sesión
- Protección CSRF en formularios

**Rutas Protegidas:**
- Middleware `auth` para rutas que requieren autenticación
- Middleware `guest` para evitar acceso a login/registro si ya está autenticado
- Redirección automática a login si se intenta acceder sin autenticación

### Uso del Sistema

**Registrarse:**
1. Hacer clic en "Registrarse" en el navbar o header
2. Completar el formulario con nombre, email y contraseña
3. Se crea la cuenta y se inicia sesión automáticamente

**Iniciar Sesión:**
1. Hacer clic en "Iniciar Sesión" en el navbar o header
2. Ingresar email y contraseña
3. Opcionalmente marcar "Recordarme"
4. Se inicia sesión y redirige a la página de inicio

**Cerrar Sesión:**
1. Hacer clic en el dropdown del usuario (navbar o header)
2. Seleccionar "Cerrar Sesión"
3. Se cierra la sesión de forma segura

---

## � Sistema de Carrito de Compras

### Características Implementadas

**Gestión del Carrito:**
- Añadir productos al carrito con control de stock
- Actualizar cantidades de productos
- Eliminar productos individuales
- Vaciar carrito completo
- Cálculo automático de totales
- Contador de items en navbar
- Persistencia en base de datos por usuario

**Validaciones de Seguridad:**
- Solo usuarios autenticados pueden acceder
- Verificación de stock en tiempo real
- Prevención de cantidades mayores al stock disponible
- Protección contra duplicados (índice único)
- Verificación de ownership (usuarios solo ven su carrito)
- Tokens CSRF en todos los formularios

**Control de Stock:**
- Validación al agregar productos
- Validación al actualizar cantidades
- Muestra stock disponible en vista
- Previene overselling
- Input con límite máximo según stock

### Uso del Carrito

**Agregar Productos:**
1. Navegar por el catálogo (Home, Productos, Categorías)
2. Click en "Añadir al Carrito" (requiere login)
3. Si el producto ya existe, incrementa cantidad automáticamente
4. Mensaje de confirmación

**Ver Carrito:**
1. Click en icono "Carrito" en navbar (muestra contador)
2. Acceder a `/cart`
3. Ver listado completo con imágenes, precios, cantidades

**Actualizar Cantidades:**
1. En vista del carrito, cambiar número en input
2. Se actualiza automáticamente al cambiar valor
3. Validación de stock en tiempo real

**Eliminar Productos:**
1. Click en botón de basura (eliminar individual)
2. O usar botón "Vaciar Carrito" (eliminar todos)
3. Confirmación antes de eliminar

**Cálculos:**
- Precio unitario por producto
- Subtotal por producto (precio × cantidad)
- Total del carrito (suma de todos los subtotales)
- Moneda: Euro (€)

### Estructura Técnica del Carrito

**Tabla `cart_items`:**
```sql
- id (bigint, PK)
- user_id (FK a users, cascade delete)
- product_id (FK a products, cascade delete)
- quantity (integer, default 1)
- price (decimal, precio al agregar)
- timestamps
- UNIQUE(user_id, product_id) -- Previene duplicados
```

**Modelo CartItem:**
- Relaciones: belongsTo(User), belongsTo(Product)
- Accessor: getSubtotalAttribute() → price × quantity
- Fillable: user_id, product_id, quantity, price
- Casts: quantity → integer, price → decimal:2

**CartController:**
- `index()`: Mostrar carrito con eager loading
- `add()`: Añadir/incrementar producto con validación de stock
- `updateQuantity()`: Actualizar cantidad con validación
- `remove()`: Eliminar producto individual
- `clear()`: Vaciar carrito completo
- `getCartCount()`: Contador para navbar (método estático)

**Rutas del Carrito:**
```php
GET    /cart                   → Ver carrito
POST   /cart/add/{product}     → Añadir producto
PATCH  /cart/update/{cartItem} → Actualizar cantidad
DELETE /cart/remove/{cartItem} → Eliminar producto
DELETE /cart/clear             → Vaciar carrito
```

Todas protegidas con middleware `auth`.

---

## 📱 Navegación Dinámica

El sistema ahora muestra diferentes opciones según el estado de autenticación:

**Usuario No Autenticado:**
- Icono de usuario en header → Link a Login
- Navbar → "Iniciar Sesión" y "Registrarse"

**Usuario Autenticado (Cliente):**
- Icono de usuario en header → Dropdown con nombre, "Panel Admin" (si es admin), "Mis Pedidos" y "Cerrar Sesión"
- Navbar → (Navbar sin opciones extras)
- **Icono de carrito con contador** (muestra número de items)
- Acceso completo al carrito de compras
- Badge "Modo Admin" en productos si es administrador

**Usuario Administrador:**
- Icono de usuario en header → Dropdown con nombre, "Panel Admin" y "Cerrar Sesión"
- No ve "Mis Pedidos" (solo para clientes)
- **Icono de carrito NO visible**
- Botones "Añadir al Carrito" reemplazados por badge "Modo Admin"
- Acceso completo a `/admin/products` para CRUD

---
## ⚙️ Panel de Administración de Productos

### Características Implementadas

**Sistema de Roles:**
- Campo `is_admin` en tabla `users` (boolean, default false)
- Método `isAdmin()` en modelo User
- Middleware `IsAdmin` para proteger rutas admin
- Solo usuarios con `is_admin = true` pueden acceder

**Interfaz de Administración:**
- **Listar Productos:** Tabla con imagen, nombre, categoría, precio, stock, destacado y acciones
- **Crear Producto:** Formulario completo con validación, carga de imagen y selección de categoría
- **Editar Producto:** Formulario pre-rellenado con opción de cambiar imagen sin recargar
- **Eliminar Producto:** Modal de confirmación estético (no alert() del navegador)

**Funcionalidades Técnicas:**
- Slug generado automáticamente desde el nombre del producto (usando Str::slug)
- Validación de datos (nombre, descripción, precio, stock, categoría, imagen)
- Subida segura de imágenes a `storage/app/public/products/`
- Eliminación automática de imagen anterior al actualizar
- Eliminación de imagen al eliminar producto
- Paginación en lista de productos
- Relación con categorías (desplegable en formularios)

**Validaciones:**
- Campo "Nombre": requerido, máximo 255 caracteres
- Campo "Descripción": requerido
- Campo "Precio": requerido, numérico, mínimo 0
- Campo "Stock": requerido, entero, mínimo 0
- Campo "Categoría": requerido, debe existir en BD
- Campo "Imagen": requerido en crear, opcional en editar, formatos válidos (jpeg, png, jpg, gif), máximo 2MB
- Campo "Destacado": checkbox boolean

### Cómo Usar el Panel Admin

**Acceder al Panel:**
1. Iniciar sesión con una cuenta administrador (ej: admin@admin.com / admin123)
2. Hacer clic en dropdown de usuario (header)
3. Seleccionar "⚙️ Panel Admin"
4. O acceder directamente a: `/admin/products`

**Crear Producto:**
1. En panel admin, clic en botón "➕ Añadir Producto"
2. Rellenar todos los campos:
   - Nombre: "Nombre del Producto"
   - Descripción: Descripción detallada
   - Precio: En formato decimal (ej: 29.99)
   - Stock: Número de unidades
   - Categoría: Seleccionar de desplegable
   - Imagen: Subir archivo (jpeg, png, jpg, gif)
   - Destacado: Marcar si quieres que aparezca en inicio
3. Slug se genera automáticamente
4. Clic en "Crear Producto"
5. Confirmación y redirección a lista

**Editar Producto:**
1. En lista de productos, clic en botón "✏️ Editar"
2. Formulario se carga con datos actuales
3. Modificar los campos deseados
4. Imagen actual se muestra (opcional cambiar)
5. Clic en "Actualizar Producto"
6. Confirmación y redirección a lista

**Eliminar Producto:**
1. En lista de productos, clic en botón "🗑️ Eliminar"
2. Modal de confirmación (estético y profesional)
3. Confirmar eliminación
4. Producto y su imagen se eliminan de la BD y Storage
5. Confirmación y redirección a lista

### Tabla: `users` (nueva columna)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| is_admin | BOOLEAN | Indica si el usuario es administrador (default: false) |

**Migración:**
```bash
php artisan migrate
```

### Rutas Admin (Protegidas)

| Ruta | Método | Descripción | Middleware |
|------|--------|-------------|------------|
| `/admin/products` | GET | Listar productos | auth, admin |
| `/admin/products/create` | GET | Formulario crear | auth, admin |
| `/admin/products` | POST | Guardar producto | auth, admin |
| `/admin/products/{id}/edit` | GET | Formulario editar | auth, admin |
| `/admin/products/{id}` | PUT | Actualizar producto | auth, admin |
| `/admin/products/{id}` | DELETE | Eliminar producto | auth, admin |

### Controlador Admin\ProductController

**Métodos:**

- `index()`: Lista todos los productos con paginación (12 por página)
- `create()`: Muestra formulario de creación con categorías
- `store()`: Valida, sube imagen y crea producto
- `edit($id)`: Muestra formulario de edición con datos actuales
- `update($id)`: Valida, actualiza producto y gestiona imagen
- `destroy($id)`: Elimina producto y su imagen del Storage

**Características:**
- Eager loading de categorías para optimizar queries
- Manejo seguro de archivos
- Generación de slug automática
- Timestamps de creación/actualización automáticos
- Eager loading: `Product::with('category')`

### Middleware IsAdmin

Verifica dos condiciones:
1. Usuario autenticado (`auth()->check()`)
2. Usuario tiene rol admin (`auth()->user()->is_admin`)

Si alguna falla, retorna respuesta 403 (Forbidden).

**Registro en Kernel:**
```php
protected $routeMiddleware = [
    // ...
    'admin' => \App\Http\Middleware\IsAdmin::class,
];
```

### Usuario Admin de Prueba

Para acceder al panel admin:

**Email:** admin@admin.com
**Contraseña:** admin123

Crear en base de datos con:
```sql
UPDATE users SET is_admin = 1 WHERE email = 'admin@admin.com';
```

---

## 🎨 Mejoras de Interfaz Implementadas

### Paginación Mejorada
- ✅ Bootstrap 5 personalizado
- ✅ Iconos de Bootstrap Icons (`bi-chevron-left`, `bi-chevron-right`)
- ✅ Texto "Anterior" y "Siguiente" (responsive - oculto en móviles)
- ✅ Centrado y responsive en todas las pantallas
- ✅ Consistente en: Catálogo, Categorías, Admin

**Configuración en AppServiceProvider:**
```php
Paginator::defaultView('vendor.pagination.bootstrap-5');
Paginator::defaultSimpleView('vendor.pagination.bootstrap-5');
```

### Modal de Confirmación
- ✅ Reemplazo de `confirm()` del navegador
- ✅ Diseño Bootstrap 5 con fondo rojo en header
- ✅ Muestra nombre del producto a eliminar
- ✅ Botones "Cancelar" y "Eliminar" bien diferenciados
- ✅ Transiciones suaves (fade)

### Restricciones para Administradores
- ✅ Carrito NO visible en navbar si es admin
- ✅ Botones "Añadir al Carrito" reemplazados por badge "Modo Admin"
- ✅ Opción "Mis Pedidos" NO visible en dropdown de admin
- ✅ Aplicado en: Home, Catálogo, Categorías, Detalle de producto
- ✅ Mensajes informativos claros

---

## 🔧 Comandos Importantes para Setup Admin

### 1. Ejecutar Migración de is_admin

```bash
php artisan migrate
```

### 2. Publicar Vistas de Paginación (Si no está hecho)

```bash
php artisan vendor:publish --tag=laravel-pagination
```

### 3. Crear Usuario Admin Manualmente (Base de Datos)

Si necesitas crear un admin directo en BD:

```sql
UPDATE users SET is_admin = 1 WHERE email = 'tu@email.com';
```

O usar tinker:

```bash
php artisan tinker
User::where('email', 'admin@admin.com')->update(['is_admin' => true]);
exit
```

### 4. Crear Migración para Campo is_admin (Si no está incluida)

```bash
php artisan make:migration add_is_admin_to_users_table --table=users
```

Editar el archivo generado:

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_admin')->default(false)->after('email');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('is_admin');
    });
}
```

Ejecutar:

```bash
php artisan migrate
```

---
