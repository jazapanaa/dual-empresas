# Diagrama de Flujo: Sistema de Búsqueda

## 1️⃣ ARQUITECTURA DE CAPAS

```
┌─────────────────────────────────────────────────────────┐
│                    NAVEGADOR (BROWSER)                  │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Input: wire:model.live="search"                │   │
│  │  <input type="text" wire:model.live="search">   │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                           ↓ (AJAX)
┌─────────────────────────────────────────────────────────┐
│              LIVEWIRE COMPONENT (PHP)                   │
│  ┌──────────────────────────────────────────────────┐   │
│  │  WarehouseEntryLive / WarehouseDispatchLive      │   │
│  │  public string $search = '';                     │   │
│  │  public function render() { ... }                │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────┐
│           TRAIT: InventoryMovementsTrait                │
│  ┌──────────────────────────────────────────────────┐   │
│  │  getInventoryMovements($type, $search)           │   │
│  │  ├─ Normalizar búsqueda                          │   │
│  │  ├─ Construir query                              │   │
│  │  └─ Filtrar por producto                         │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                           ↓ (SQL)
┌─────────────────────────────────────────────────────────┐
│              BASE DE DATOS (MySQL)                      │
│  ┌──────────────────────────────────────────────────┐   │
│  │  SELECT * FROM inventory_movements               │   │
│  │  WHERE movement_type_id = ? AND                  │   │
│  │        product_id IN (SELECT id FROM products    │   │
│  │                      WHERE LOWER(name) LIKE ?)   │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────┐
│              BLADE VIEW (Template)                      │
│  ┌──────────────────────────────────────────────────┐   │
│  │  @foreach ($inventoryMovements as $movement)    │   │
│  │    <tr>...</tr>                                  │   │
│  │  @endforeach                                     │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                           ↓ (HTML)
┌─────────────────────────────────────────────────────────┐
│                 NAVEGADOR (Renderizado)                 │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Tabla actualizada con resultados filtrados      │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

---

## 2️⃣ FLUJO DE EJECUCIÓN PASO A PASO

```
┌─────────────────────────────────────────────────────────┐
│ USUARIO ESCRIBE: "papel"                                │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 1: Cambio en Input                                 │
│ wire:model.live detecta el cambio                       │
│ Valor: $search = "papel"                                │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 2: Livewire Envía AJAX al Servidor                 │
│ POST /almacen/warehouse/entries                         │
│ Parámetros: { 'search': 'papel' }                       │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 3: PHP Ejecuta render()                            │
│ WarehouseEntryLive::render() se llama                   │
│ Pasa $search = "papel" a getInventoryMovements()        │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 4: Trait Normaliza Búsqueda                        │
│ "papel" → normalizeString() → "papel"                   │
│ (Sin cambios, pero listo para comparar con BD)          │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 5: Construir Query                                 │
│ SELECT inventory_movements WHERE movement_type_id = 1   │
│ AND product_id IN (SELECT id FROM products WHERE       │
│     LOWER(name) LIKE '%papel%')                         │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 6: Ejecutar en Base de Datos                       │
│ Resultados encontrados:                                 │
│ - PAPEL HIGIÉNICO JUMBO 24 GR                           │
│ - PAPEL KRAFT 80 GR                                     │
│ - PAPEL BOND BLANCO                                     │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 7: Paginar Resultados                              │
│ paginate(50) → Solo 50 por página (si hay más)          │
│ Total: 3 resultados en página 1                         │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 8: Renderizar Vista Blade                          │
│ Ejecuta @foreach con resultados                         │
│ Genera HTML de la tabla                                 │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 9: Enviar Respuesta AJAX                           │
│ HTTP 200 OK                                             │
│ HTML actualizado                                        │
└─────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────┐
│ PASO 10: Navegador Actualiza DOM                        │
│ Tabla se muestra con los 3 resultados                   │
│ Usuario ve: PAPEL HIGIÉNICO, PAPEL KRAFT, PAPEL BOND    │
└─────────────────────────────────────────────────────────┘
```

---

## 3️⃣ DIAGRAMA DE OBJETOS Y RELACIONES

```
InventoryMovement (Tabla: inventory_movements)
├── id: INT PRIMARY KEY
├── product_id: INT (FK → Product)
├── warehouse_id: INT (FK → Warehouse)
├── movement_type_id: INT (FK → MovementType)
├── quantity: INT
├── movement_date: DATETIME
├── reference: VARCHAR
├── notes: TEXT
├── user_id: INT (FK → User)
└── created_at, updated_at: TIMESTAMP

Product (Tabla: products)
├── id: INT PRIMARY KEY
├── code: VARCHAR
├── name: VARCHAR ⭐ CAMPO DE BÚSQUEDA
├── description: TEXT
├── category_id: INT
└── unit_id: INT

Warehouse (Tabla: warehouses)
├── id: INT PRIMARY KEY
├── name: VARCHAR
├── location: VARCHAR
└── created_at, updated_at: TIMESTAMP
```

**Relación en la Búsqueda:**
```
InventoryMovement (movement_type_id = 1, 'Entrada')
    ↓ whereHas('product')
Product (WHERE LOWER(name) LIKE '%papel%')
    ↓ resultado
Coincide ✅ → Se incluye en resultados
No coincide ❌ → Se excluye de resultados
```

---

## 4️⃣ EJEMPLO COMPLETO: Buscar "guantes"

### Input del Usuario:
```html
<input wire:model.live="search" value="guantes">
```

### En WarehouseEntryLive.php:
```php
public string $search = 'guantes';  // Actualizado automáticamente

public function render()
{
    return view('livewire.warehouse.warehouse-entry-live',[
        'inventoryMovements' => $this->getInventoryMovements(
            'Entrada',      // tipo de movimiento
            'guantes'       // búsqueda
        )->paginate(50),
        ...
    ]);
}
```

### En InventoryMovementsTrait.php:
```php
public function getInventoryMovements('Entrada', 'guantes')
{
    // 1. Obtener ID del tipo de movimiento
    $movement_type_id = 1;  // Entrada
    
    // 2. Construir query
    $query = InventoryMovement::where('movement_type_id', 1)
        ->with(['product', 'warehouse']);
    
    // 3. Normalizar búsqueda
    $searchTerm = 'guantes';  // Ya está normalizado
    
    // 4. Filtrar por producto
    $query->whereHas('product', function ($q) {
        $q->whereRaw('LOWER(name) LIKE ?', ['%guantes%']);
    });
    
    // 5. Ordenar y retornar
    return $query->orderBy('created_at', 'desc');
    
    // SQL GENERADO:
    // SELECT inventory_movements.*
    // FROM inventory_movements
    // INNER JOIN products ON inventory_movements.product_id = products.id
    // WHERE movement_type_id = 1
    // AND LOWER(products.name) LIKE '%guantes%'
    // ORDER BY created_at DESC
}
```

### Resultados de la Base de Datos:
```
movement_id │ product_id │ product_name              │ quantity │ warehouse
────────────┼────────────┼───────────────────────────┼──────────┼──────────
1           │ 5          │ GUANTES VIRUTEX AZULES    │ 10       │ Almacén 1
2           │ 8          │ Guantes de Protección     │ 5        │ Almacén 2
3           │ 12         │ GUANTES LATEX S/POLVO     │ 20       │ Almacén 3
```

### Vista Blade Renderea:
```html
<tr>
    <td>GUANTES VIRUTEX AZULES</td>
    <td>Almacén 1</td>
    <td>10</td>
    <td>2026-01-13 14:30:00</td>
    <td><!-- Botones --></td>
</tr>
<tr>
    <td>Guantes de Protección</td>
    <td>Almacén 2</td>
    <td>5</td>
    <td>2026-01-12 10:15:00</td>
    <td><!-- Botones --></td>
</tr>
<tr>
    <td>GUANTES LATEX S/POLVO</td>
    <td>Almacén 3</td>
    <td>20</td>
    <td>2026-01-10 09:00:00</td>
    <td><!-- Botones --></td>
</tr>
```

### Usuario Ve en Navegador:
```
┌─────────────────────────────────────────────────┐
│ [Búscar producto____________] [Excel] [PDF]     │
├──────────────────────────────────────────────────┤
│ Producto              │ Almacén   │ Cantidad     │
├──────────────────────────────────────────────────┤
│ GUANTES VIRUTEX AZU.. │ Almacén 1 │ 10          │
│ Guantes de Protect... │ Almacén 2 │ 5           │
│ GUANTES LATEX S/POL.. │ Almacén 3 │ 20          │
└──────────────────────────────────────────────────┘
```

---

## 5️⃣ CASOS ESPECIALES

### Caso 1: Búsqueda Vacía
```php
$search = '';  // Usuario borra el texto

// En getInventoryMovements()
if ($search) {  // ❌ No se ejecuta
    // ...
}
// ✅ Se retornan TODOS los movimientos de tipo 'Entrada'
```

### Caso 2: Sin Coincidencias
```php
$search = 'xyzabc123';  // Algo que no existe

// Query ejecutada:
// WHERE LOWER(products.name) LIKE '%xyzabc123%'
// No hay coincidencias

// ✅ Resultado: Tabla vacía sin mensajes
```

### Caso 3: Búsqueda con Acentos
```php
// Usuario escribe: "Útiles"
$search = 'Útiles';

// normalizeString() convierte a: "utiles"

// Se busca en BD: LOWER(name) LIKE '%utiles%'
// Encuentra: "ÚTILES PARA OFICINA" ✅
```

### Caso 4: Búsqueda con Mayúsculas
```php
// Usuario escribe: "PAPEL"
$search = 'PAPEL';

// normalizeString() convierte a: "papel"

// Se busca en BD: LOWER(name) LIKE '%papel%'
// Encuentra: "Papel higiénico" ✅
```

---

## 6️⃣ TIMELINE DE ACTUALIZACIÓN

```
T=0ms  Usuario escribe "p"
       └─→ wire:model.live envía AJAX

T=50ms Servidor recibe solicitud
       └─→ PHP ejecuta render()

T=75ms Base de datos ejecuta query
       └─→ Encuentra resultados

T=100ms Blade renderiza vista
        └─→ HTML generado

T=120ms AJAX responde al navegador
        └─→ DOM se actualiza

T=150ms Usuario ve resultados filtrados
        └─→ Proceso completo
```

**Total: ~150ms (depende del servidor y conexión)**

---

## 7️⃣ COMPONENTES CLAVE REUTILIZABLES

### Para Agregar Búsqueda a Otro Componente:

1. **Agregar propiedad:**
```php
public string $search = '';
```

2. **Actualizar render():**
```php
'items' => $this->getItems($this->search)->paginate(50),
```

3. **Agregar método de obtención:**
```php
public function getItems($search = null)
{
    $query = Model::query();
    
    if ($search) {
        $searchTerm = $this->normalizeString($search);
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
    }
    
    return $query->orderBy('created_at', 'desc');
}
```

4. **Agregar input en vista:**
```blade
<input type="text" wire:model.live="search" placeholder="Buscar...">
```

---

**Versión**: 1.0  
**Última actualización**: 13 de enero de 2026
