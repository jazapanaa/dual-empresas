# Documentación: Sistema de Búsqueda y Filtrado de Inventario

## 📋 Descripción General

Este documento explica cómo está construido el sistema de búsqueda y filtrado de productos en las secciones de **Ingreso a Almacén** y **Salida de Almacén**.

---

## 🏗️ Arquitectura del Sistema

### Componentes Principales

```
Usuario (Navegador)
    ↓
Livewire Component (WarehouseEntryLive / WarehouseDispatchLive)
    ↓
Blade View (warehouse-entry-live.blade.php / warehouse-dispatch-live.blade.php)
    ↓
Traits (InventoryMovementsTrait)
    ↓
Base de Datos (InventoryMovement, Product, Warehouse)
```

---

## 🔄 Flujo de Búsqueda en Tiempo Real

### Paso 1: Usuario Escribe en el Campo de Búsqueda
```html
<input type="text" 
       wire:model.live="search"
       placeholder="Buscar producto">
```

**Qué hace `wire:model.live`:**
- Vincula automáticamente el valor del input a la propiedad `$search` del componente Livewire
- El modificador `.live` significa que se actualiza **en tiempo real** mientras escribes
- No necesita presionar Enter ni hacer clic en un botón

---

### Paso 2: Livewire Actualiza la Propiedad
```php
// En WarehouseEntryLive.php
public string $search = '';  // Se actualiza automáticamente
```

Cuando el usuario escribe, Livewire:
1. Detecta el cambio en el input
2. Actualiza la propiedad `$search` en el componente
3. Ejecuta automáticamente el método `render()`

---

### Paso 3: Método Render Obtiene Datos Filtrados
```php
// En WarehouseEntryLive.php :: render()
public function render()
{
    return view('livewire.warehouse.warehouse-entry-live',[
        'inventoryMovements' => $this->getInventoryMovements(
            $this->movement_type,  // 'Entrada' o 'Salida'
            $this->search          // Término de búsqueda actual
        )->paginate(50),
        'products' => $this->ddlProducts(),
        'warehouses' => $this->ddlWarehouses(),
    ]);
}
```

**Qué sucede:**
- Se llama a `getInventoryMovements()` con el término de búsqueda
- Se obtienen solo los registros que coinciden
- Se paginan los resultados (50 por página)
- La vista se actualiza con los nuevos datos

---

### Paso 4: Trait Filtra los Datos en la Base de Datos
```php
// En InventoryMovementsTrait.php :: getInventoryMovements()
public function getInventoryMovements($type, $search = null)
{
    // 1. Obtener el tipo de movimiento (ID)
    $movement_type_id = $this->getMovementTypeByField('name', $type)->id;
    
    // 2. Construir la consulta base
    $query = InventoryMovement::where('movement_type_id', $movement_type_id)
        ->with(['product', 'warehouse']);
    
    // 3. Si hay búsqueda, filtrar por nombre de producto
    if ($search) {
        $searchTerm = $this->normalizeString($search);
        $query->whereHas('product', function ($q) use ($searchTerm) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        });
    }
    
    // 4. Ordenar por fecha (más recientes primero)
    return $query->orderBy('created_at', 'desc');
}
```

**Detalles técnicos:**
- `whereHas('product', ...)` busca en la tabla relacionada de productos
- `LOWER(name) LIKE ?` busca sin importar mayúsculas/minúsculas
- `normalizeString()` también elimina acentos para mejor búsqueda

---

### Paso 5: Vista Muestra los Resultados
```blade
<!-- En warehouse-entry-live.blade.php -->
@foreach ($inventoryMovements as $inventoryMovement)
    <tr>
        <td>{{ $inventoryMovement->product->name }}</td>
        <td>{{ $inventoryMovement->warehouse->name }}</td>
        <td>{{ $inventoryMovement->quantity }}</td>
        <td>{{ $inventoryMovement->movement_date }}</td>
        <!-- Botones de acción -->
    </tr>
@endforeach
```

---

## 🔍 Función de Normalización de Búsqueda

La función `normalizeString()` prepara el texto para búsqueda sin diferencias:

```php
private function normalizeString($string)
{
    // Convertir a minúsculas
    $string = mb_strtolower($string, 'UTF-8');

    // Eliminar acentos
    $string = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', ...],
        ['a', 'e', 'i', 'o', 'u', 'u', 'n', ...],
        $string
    );

    return trim($string);
}
```

**Ejemplos:**
```
Entrada de usuario: "Papél Higiénico"
Después de normalizar: "papel higienico"

Entrada de usuario: "GUANTES"
Después de normalizar: "guantes"

Entrada de usuario: "Útiles"
Después de normalizar: "utiles"
```

---

## 📁 Archivos Modificados

### 1. **app/Http/Traits/InventoryMovementsTrait.php**
- Método `getInventoryMovements($type, $search = null)` - Obtiene movimientos filtrados
- Método `normalizeString($string)` - Normaliza términos de búsqueda

### 2. **app/Livewire/Warehouse/WarehouseEntryLive.php**
- Propiedad `public string $search = ''` - Almacena el término de búsqueda
- Método `render()` - Pasa el parámetro `$search` a `getInventoryMovements()`

### 3. **app/Livewire/Warehouse/WarehouseDispatchLive.php**
- Propiedad `public string $search = ''` - Almacena el término de búsqueda
- Método `render()` - Pasa el parámetro `$search` a `getInventoryMovements()`

### 4. **resources/views/livewire/warehouse/warehouse-entry-live.blade.php**
- Campo de búsqueda con `wire:model.live="search"`

### 5. **resources/views/livewire/warehouse/warehouse-dispatch-live.blade.php**
- Campo de búsqueda con `wire:model.live="search"`

---

## 🔗 Relaciones de Modelos

```
InventoryMovement
├── product_id → Product
├── warehouse_id → Warehouse
├── movement_type_id → MovementType
└── user_id → User

Product
├── id
├── code
├── name
├── description
├── category_id → Category
└── unit_id → Unit
```

---

## 💡 Conceptos Clave

### Livewire Component
- Componente reactivo que sincroniza automáticamente estado entre el navegador y servidor
- Cuando una propiedad pública cambia, se ejecuta `render()` automáticamente

### wire:model.live
- Une un elemento HTML a una propiedad del componente
- Actualiza **en tiempo real** mientras escribes
- Cada cambio dispara una solicitud AJAX al servidor

### Trait
- Reutiliza código entre clases
- `InventoryMovementsTrait` contiene lógica de base de datos
- Usado por `WarehouseEntryLive` y `WarehouseDispatchLive`

### whereHas()
- Filtra registros basados en condiciones en relaciones
- Ejemplo: "Obtener movimientos cuyo producto coincida con X"

---

## 🚀 Optimizaciones Realizadas

1. **with(['product', 'warehouse'])**: Carga relaciones para evitar queries extra (N+1)
2. **orderBy('created_at', 'desc')**: Muestra entradas más recientes primero
3. **Normalización de búsqueda**: Permite buscar independientemente de acentos/mayúsculas
4. **Paginación**: Carga solo 50 registros por página para mejor rendimiento

---

## 🎯 Casos de Uso

### Búsqueda de "papel"
- Usuario escribe: "papel"
- Se normaliza a: "papel"
- Se encuentra: "PAPEL HIGIÉNICO", "papel kraft", "papél bond", etc.

### Búsqueda de "guantes"
- Usuario escribe: "guantes"
- Se normaliza a: "guantes"
- Se encuentra: "GUANTES VIRUTEX", "Guantes de Protección", etc.

### Búsqueda vacía
- Si no hay texto en la búsqueda, se muestran TODOS los movimientos
- La condición `if ($search)` no se ejecuta

---

## 🔧 Cómo Extender Este Sistema

### Agregar búsqueda adicional (por almacén)
```php
// En InventoryMovementsTrait
if ($search) {
    $searchTerm = $this->normalizeString($search);
    $query->where(function($q) use ($searchTerm) {
        $q->whereHas('product', function($p) use ($searchTerm) {
            $p->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        })
        ->orWhereHas('warehouse', function($w) use ($searchTerm) {
            $w->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        });
    });
}
```

### Agregar más campos al formulario
```blade
<!-- En warehouse-entry-live.blade.php -->
<div class="form-group">
    <label>Nuevo campo</label>
    <input wire:model="form.campo_nuevo">
</div>
```

---

## ✅ Checklist de Desarrollo

- [x] Búsqueda en tiempo real sin presionar botones
- [x] Filtrado por nombre de producto
- [x] Soporte para acentos y mayúsculas
- [x] Paginación de resultados
- [x] Exportación a Excel
- [x] Documentación completa
- [x] Componentes comentados

---

## 📚 Referencias

- **Framework**: Laravel 12
- **Componentes Reactivos**: Livewire 3
- **Templating**: Blade
- **Base de Datos**: MySQL/MariaDB

---

## 📞 Preguntas Frecuentes

**P: ¿Por qué no funciona la búsqueda?**
A: Verifica que la propiedad `$search` esté declarada como `public string $search = ''`

**P: ¿Cómo cambio el número de registros por página?**
A: En el método `render()`, cambia `.paginate(50)` a el número deseado

**P: ¿Puedo buscar por múltiples campos?**
A: Sí, agrega más condiciones `whereHas()` o `where()` en `getInventoryMovements()`

**P: ¿Cómo agrego validación de stock antes de salidas?**
A: Usa el método `validarStockDisponible()` en `WarehouseDispatchLive`

---

**Última actualización**: 13 de enero de 2026
**Versión**: 1.0
