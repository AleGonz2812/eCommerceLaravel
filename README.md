# eCommerce Laravel - Tienda de Productos Digitales

eCommerce tipo G2A para venta de juegos, suscripciones, keys y productos digitales.

**Estado:** ✅ NIVEL BÁSICO COMPLETADO

---

## 📋 Descripción del Proyecto

Aplicación web de comercio electrónico desarrollada con **Laravel 8**, aplicando la estructura MVC con **Blade** (vistas) y **Eloquent** (ORM). Sistema de catálogo de productos digitales con filtrado por categorías, búsqueda y gestión de productos.

### Características Implementadas

- ✅ Sistema de categorías y productos
- ✅ Búsqueda de productos
- ✅ Filtrado por categorías
- ✅ Vista de catálogo con paginación
- ✅ Ficha detallada de productos
- ✅ Productos destacados en página principal
- ✅ Diseño responsive (mobile-first)
- ✅ Modo claro/oscuro con persistencia
- ✅ Bootstrap 5.3 + Bootstrap Icons

### Estructura MVC

- **Modelos**: Product, Category, User
- **Vistas**: Layout base, Home, Catálogo, Ficha de producto, Categorías
- **Controladores**: HomeController, ProductController, CategoryController, CartController

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

### ⏳ NIVEL INTERMEDIO - PENDIENTE
- Gestión de sesiones de usuario
- Carrito de compras (añadir/eliminar productos)
- Cálculo del total de la compra
- Gestión de imágenes

### ⏳ NIVEL EXPERTO - PENDIENTE
- Sistema de pedidos (orders, order_items)
- Autenticación de usuarios
- Proceso de checkout completo
- Historial de pedidos

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

Luego genera la clave de la aplicación:
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
- ✅ Tablas: users, categories, products, failed_jobs, password_resets, personal_access_tokens

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
│   │   │   └── CartController.php          # Carrito (pendiente)
│   │   └── ViewComposers/
│   │       └── NavigationComposer.php      # Comparte categorías globalmente
│   ├── Models/
│   │   ├── Category.php                    # Modelo de categorías
│   │   ├── Product.php                     # Modelo de productos
│   │   └── User.php                        # Modelo de usuarios
│   └── Providers/
│       └── AppServiceProvider.php          # Registro de ViewComposer
├── database/
│   ├── migrations/
│   │   ├── create_categories_table.php
│   │   └── create_products_table.php
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
│       │   └── footer.blade.php            # Pie de página
│       ├── products/
│       │   ├── index.blade.php             # Catálogo
│       │   └── show.blade.php              # Ficha de producto
│       ├── category/
│       │   └── show.blade.php              # Productos por categoría
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

**Relaciones:**
- `categories` → `products` (1:N)

---

## 🛣️ Rutas Disponibles

| Ruta | Método | Descripción |
|------|--------|-------------|
| `/` | GET | Página de inicio con productos destacados |
| `/products` | GET | Catálogo completo de productos (paginado) |
| `/products/search?q={query}` | GET | Búsqueda de productos |
| `/products/{slug}` | GET | Ficha detallada de un producto |
| `/category/{slug}` | GET | Productos filtrados por categoría |
| `/cart` | GET | Ver carrito (pendiente implementación) |

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

### Componentes
- ✅ Cards de productos con hover effect
- ✅ Badges de categoría y destacados
- ✅ Sistema de paginación
- ✅ Breadcrumbs en ficha de producto
- ✅ Indicadores de stock (disponible/agotado)

---
