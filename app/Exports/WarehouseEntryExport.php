<?php

namespace App\Exports;

use App\Models\InventoryMovement;
use Maatwebsite\Excel\Concerns\FromCollection;

class WarehouseEntryExport implements FromCollection
{
    public function collection()
    {
        return InventoryMovement::all();
    }
}
