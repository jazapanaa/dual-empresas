<?php

namespace App\Exports;

use App\Http\Traits\ProductTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection,WithHeadings
{
    use ProductTrait;

    public function collection()
    {
        return $this->getProductsFromExport();
    }
    public function headings(): array
    {
        return [
            '#',
            'código',
            'Nombre',
            'Descripción',
            'categoría',
            'Unidad',
        ];
    }
}
