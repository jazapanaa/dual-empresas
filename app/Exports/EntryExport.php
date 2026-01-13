<?php

namespace App\Exports;

use App\Http\Traits\InventoryMovementsTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntryExport implements FromCollection,WithHeadings
{
    use InventoryMovementsTrait;
    public function collection()
    {
        return $this->dataExportMovement(1);
    }
    public function headings(): array
    {
        return [
            'Producto',
            'Almacén',
            'Cantidad',
            'Fecha del movimiento',
            'Referencia',
            'Notas',
            'Usuario',
        ];
    }
}
