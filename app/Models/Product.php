<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    protected $guarded = ['id'];
    use LogsActivity;

    // Otros atributos y métodos del modelo...

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'category_id', 'price'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('product')
            ->setDescriptionForEvent(fn(string $eventName) => "Producto {$eventName}");
    }
    /**
     * Obtiene la categoría a la que pertenece el producto
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtiene el proveedor del producto
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Obtiene la unidad de medida del producto
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    protected static function booted()
    {
        static::created(function ($product) {
            $name = mb_strtoupper(substr(self::normalizeString($product->name), 0, 3));
            $suffix = str_pad($product->id, 5, '0', STR_PAD_LEFT);
            $product->code = $name . $suffix;
            $product->saveQuietly();
        });
    }

    private static function normalizeString($string)
    {
        $string = strtr(
            mb_strtolower($string, 'UTF-8'),
            [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                'ü' => 'u', 'ñ' => 'n',
                'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
                'Ü' => 'U', 'Ñ' => 'N'
            ]
        );
        return preg_replace('/[^A-Za-z0-9]/u', '', $string);
    }

}
