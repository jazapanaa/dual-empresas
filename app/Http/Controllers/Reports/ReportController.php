<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\InventoryMovementsTrait;
use App\Http\Traits\ProductTrait;
use App\Http\Traits\ReportsTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ReportsTrait,InventoryMovementsTrait;
    public function inventoryPdf():void
    {
        $this->InitPdf('Inventario',orientation: 'L');
        $data = $this->dataExportInventory();
        $this->reportTitle('Inventario');
        $columns = [
            ['key' => 'product_name', 'label' => 'Producto', 'width' => 115],
            ['key' => 'warehouse_name', 'label' => 'Almacén', 'width' => 23],
            ['key' => 'quantity', 'label' => 'Cantidad', 'width' => 25],
            ['key' => 'created_at', 'label' => 'Fecha creación', 'width' => 45],
            ['key' => 'updated_at', 'label' => 'Fecha Actualización', 'width' => 45],
        ];
        $this->reportTableHeader($columns,15,41,true);

        $this->reportRenderData(
            $data,
            $columns,
            x: 15,
            startY: 47,
            withIndex: true,
            limit: 45
        );

        $this->outputPdf('reporte_inventario');
    }
    public function movementPdf($id):void
    {
        $name = ($id == 1) ? 'Entradas' : 'Salidas';
        $this->InitPdf($name,orientation: 'L');
        $data = $this->dataExportMovement($id);
        $this->reportTitle('Reporte de '.$name);
        $columns = [
            ['key' => 'product_name', 'label' => 'Producto', 'width' => 115],
            ['key' => 'warehouse_name', 'label' => 'Almacén', 'width' => 23],
            ['key' => 'quantity', 'label' => 'Cantidad', 'width' => 25,'align' => 'C'],
            ['key' => 'movement_date', 'label' => 'Movimiento', 'width' => 50],
            ['key' => 'user_name', 'label' => 'usuario', 'width' => 45],
        ];
        $this->reportTableHeader($columns,15,41,true);

        $this->reportRenderData(
            $data,
            $columns,
            x: 15,
            startY: 47,
            withIndex: true,
            limit: 45
        );

        $this->outputPdf('reporte_'.$name);

    }
}
