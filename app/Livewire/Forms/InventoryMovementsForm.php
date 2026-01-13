<?php

namespace App\Livewire\Forms;

use App\Models\InventoryMovement;
use App\Models\Stock;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InventoryMovementsForm extends Form
{
    #[Validate('required')]
    public int $product_id = 0;
    #[Validate('required')]
    public int $warehouse_id = 0;
    #[Validate('required')]
    public int $quantity = 0;
    #[Validate('required')]
    public $movement_date = '';

    public int $user_id = 0;
    public int $movement_type_id = 0;
    public $reference = '';
    public $notes = '';

    public $data =[
        'product_id',
        'movement_type_id',
        'warehouse_id',
        'quantity',
        'user_id',
        'movement_date',
        'reference',
        'notes'
    ];

    public function store()
    {
        $this->validate();

        InventoryMovement::create(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function show(InventoryMovement $inventory_movement): void
    {
        $this->fill([
            'product_id' => $inventory_movement->product_id,
            'movement_type_id' => $inventory_movement->movement_type_id,
            'warehouse_id' => $inventory_movement->warehouse_id,
            'quantity' => $inventory_movement->quantity,
            'movement_date' => $inventory_movement->movement_date,
        ]);
    }
    public function update(InventoryMovement $inventory_movement): void
    {
        $this->validate();

        $inventory_movement->update(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function delete($inventory_movement_id,$type): void
    {
        $inventory_movement = InventoryMovement::find($inventory_movement_id);
        $product_id = $inventory_movement->product_id;
        $quantity = $inventory_movement->quantity;
        $operation = $type === 'Entrada' ? '-' : '+';
        $stock = Stock::where('product_id', $product_id)
            ->where('warehouse_id', $inventory_movement->warehouse_id)->first();
        if ($stock) {
            // Actualiza el stock según el tipo de movimiento
            if ($operation === '-') {
                $stock->quantity -= $quantity;
            } else {
                $stock->quantity += $quantity;
            }
            //Si la diferencia es 0 elimina el stock
            if ($stock->quantity <= 0) {
                $stock->delete();
            } else {
                $stock->save();
            }
        }

        // Verifica si el movimiento de inventario existe antes de intentar eliminarlo
        if (!$inventory_movement) {
            return;
        }
        $inventory_movement->delete();
    }
}
