<?php

namespace App\Models;

use App\Events\InventoryMovementCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InventoryMovement extends Model
{
    protected $guarded = ['id'];
    use LogsActivity;

    /**
     * Obtiene las opciones de registro de actividad
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'movement_type_id', 'warehouse_id', 'user_id', 'quantity'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('inventory_movement')
            ->setDescriptionForEvent(fn(string $eventName) => "Movimiento de inventario {$eventName}");
    }

    /**
     * Obtiene el producto asociado al movimiento de inventario
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Obtiene el tipo de movimiento
     */
    public function movementType(): BelongsTo
    {
        return $this->belongsTo(MovementType::class);
    }

    /**
     * Obtiene el almacén asociado al movimiento
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Obtiene el usuario que realizó el movimiento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $dispatchesEvents = [
        'created' => InventoryMovementCreated::class,
        'updated' => InventoryMovementCreated::class,
    ];

}
