# eCommerce Laravel - Tienda de Productos Digitales

eCommerce tipo G2A para venta de juegos, suscripciones, keys y productos digitales.

---

## Descripción del Proyecto

Aplicación web de comercio electrónico desarrollada con **Laravel 8**, aplicando la estructura MVC con **Blade** (vistas) y **Eloquent** (ORM).

### Estructura MVC

- **Modelo**: Productos, Categorías, Carrito, Pedidos
- **Vista**: Catálogo, Ficha de producto, Formulario de pago
- **Controlador**: Lógica de añadir al carrito, procesar compra

---

## Fases del Proyecto

### NIVEL BÁSICO
Creación del proyecto Laravel, configurar base de datos, migraciones de `categories` y `products`, modelos Category y Product, mostrar catálogo de productos y filtrar productos por categorías.

### NIVEL INTERMEDIO
Gestión de sesiones de usuario, carrito de compras (añadir/eliminar productos), cálculo del total de la compra y configurar storage para imágenes de productos.

### NIVEL EXPERTO
Relaciones Eloquent entre tablas, sistema de pedidos (`orders`, `order_items`), autenticación de usuarios y proceso de checkout completo.

---

## Requisitos

- PHP >= 8.0
- Composer
- MySQL (XAMPP)
- Node.js (opcional, para assets)

---

## Instalación

1. Clonar el repositorio e ir al directorio del proyecto
2. Instalar dependencias con `composer install`
3. Copiar `.env.example` a `.env` y generar la clave con `php artisan key:generate`
4. Configurar la base de datos en `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
5. Crear la base de datos `ecommerce_laravel` en phpMyAdmin
6. Ejecutar migraciones con `php artisan migrate`
7. Iniciar servidor con `php artisan serve`

---

## Estructura del Proyecto

- **app/Http/Controllers/**: Controladores (ProductController, CategoryController, CartController, OrderController)
- **app/Models/**: Modelos Eloquent (User, Category, Product, Order, OrderItem)
- **database/migrations/**: Estructura de las tablas
- **database/seeders/**: Datos iniciales
- **resources/views/**: Vistas Blade organizadas por carpetas (layouts, products, cart, checkout)
- **routes/web.php**: Definición de rutas de la aplicación
- **public/**: Assets públicos (CSS, JS, imágenes)
- **storage/**: Archivos subidos por usuarios

---

## Esquema de Base de Datos

**categories**: id, name, slug, created_at, updated_at

**products**: id, category_id (FK), name, slug, description, price, image, stock, created_at, updated_at

**orders**: id, user_id (FK), total, status, created_at, updated_at

**order_items**: id, order_id (FK), product_id (FK), quantity, price, created_at, updated_at

---

## Rutas Principales

- `GET /` - Página de inicio
- `GET /products` - Catálogo de productos
- `GET /products/{slug}` - Ficha de producto
- `GET /category/{slug}` - Productos por categoría
- `GET /cart` - Ver carrito
- `POST /cart/add/{id}` - Añadir al carrito
- `DELETE /cart/remove/{id}` - Eliminar del carrito
- `GET /checkout` - Proceso de pago
- `POST /checkout` - Procesar compra
