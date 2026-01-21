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

### 1. Clonar el repositorio
```bash
git clone https://github.com/AleGonz2812/eCommerceLaravel.git
cd eCommerceLaravel
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar archivo de entorno
```bash
# Copiar el archivo de ejemplo
copy .env.example .env

# Generar la clave de aplicación
php artisan key:generate
```

### 4. Configurar la base de datos
Editar el archivo `.env` y configurar la conexión a MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Crear la base de datos
- Iniciar XAMPP (Apache y MySQL)
- Abrir phpMyAdmin: http://localhost/phpmyadmin
- Crear una nueva base de datos llamada `ecommerce_laravel`

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh --seed
```
Esto creará las tablas y poblará la base de datos con:
- 5 categorías (Videojuegos, Suscripciones, Tarjetas Gaming, Mystery Keys, Software)
- 23 productos distribuidos en las categorías

### 7. Crear enlace simbólico para imágenes
```bash
php artisan storage:link
```

### 8. Agregar las imágenes del proyecto
Descargar las imágenes y colocarlas en:
- `storage/app/public/categories/` (5 imágenes de categorías)
- `storage/app/public/products/` (24 imágenes de productos)

**Nota:** Las imágenes se pueden descargar desde [enlace compartido] o solicitarlas al equipo.

### 9. Iniciar el servidor de desarrollo
```bash
php artisan serve
```
El proyecto estará disponible en: **http://localhost:8000**

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

**categories**: id, name, slug, image, created_at, updated_at

**products**: id, category_id (FK), name, slug, description, price, image, stock, featured, created_at, updated_at

**orders**: id, user_id (FK), total, status, created_at, updated_at

**order_items**: id, order_id (FK), product_id (FK), quantity, price, created_at, updated_at

---

## Estado Actual del Proyecto

✅ **Completado:**
- Estructura base de Laravel configurada
- Modelos: Category, Product, User
- Migraciones de categories y products
- Seeders con datos de prueba (5 categorías, 23 productos)
- Storage configurado con enlace simbólico

⏳ **En desarrollo:**
- Layout base Blade (SCRUM-10)
- Vista de catálogo de productos (SCRUM-11)
- Vista de ficha de producto (SCRUM-12)
- Filtro por categorías (SCRUM-13)

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
