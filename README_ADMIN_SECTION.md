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
