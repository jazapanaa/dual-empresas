<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\ProductTrait;
use App\Livewire\Forms\ProductSuppliersForm;
use Livewire\Component;

class ProductSuppliersLive extends Component
{
    use DdlTrait,ProductTrait;
    public ProductSuppliersForm $form;
    public $product;
    public bool $isEdit = false;
    public int $product_supplier_id;
    public function render()
    {
        return view('livewire.warehouse.product-suppliers-live',[
            'products_suppliers' => $this->getSuppliersByProduct($this->product->id),
            'suppliers' => $this->ddlSuppliers()
        ]);
    }
    public function mount($product_id)
    {
        $this->product = $this->getProduct($product_id);
    }
    public function saveProductSupplier():void
    {
        if($this->isEdit){
            $this->form->update($this->getProductSupplier($this->product_supplier_id));
            $title = 'Proveedor actualizado';
            $icon = 'success';
            $message = 'Proveedor actualizado correctamente';
            $this->isEdit = false;
        }else{
            $this->form->product_id = $this->product->id;
            $this->form->store();
            $title = 'Proveedor guardado';
            $icon = 'success';
            $message = 'Proveedor guardado correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editProductSupplier($product_supplier_id):void
    {
        $this->form->show($this->getProductSupplier($product_supplier_id));
        $this->isEdit = true;
        $this->product_supplier_id = $product_supplier_id;
    }
    public function deleteProductSupplier($product_supplier_id):void
    {
        $this->form->delete($product_supplier_id);
    }
}
