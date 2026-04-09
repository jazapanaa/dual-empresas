<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class InventoryExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Stock::with(['product', 'warehouse'])
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->select('stocks.*')
            ->orderBy('products.name', 'asc')
            ->get()
            ->map(function ($stock) {
                return [
                    'Producto' => $stock->product->name,
                    'Almacén' => $stock->warehouse->name,
                    'Cantidad' => $stock->quantity,
                    'Fecha creación' => $stock->created_at,
                    'Fecha actualización' => $stock->updated_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Producto',
            'Almacén',
            'Cantidad',
            'Fecha creación',
            'Fecha actualización',
        ];
    }
}
