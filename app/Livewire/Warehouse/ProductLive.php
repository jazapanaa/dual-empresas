<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\ProductTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\ProductForm;
use Livewire\Component;
use Livewire\WithPagination;

class ProductLive extends Component
{
    use ProductTrait, DdlTrait, WithPagination;
    public ProductForm $form;
    public bool $isEdit = false;
    public int $product_id;
    public string $search = '';
    public function render()
    {
        return view('livewire.warehouse.product-live',[
            'products' => $this->getProducts($this->search)->orderBy('created_at','desc')->paginate(50),
            'categories' => $this->ddlCategories(),
            'suppliers' => $this->ddlSuppliers(),
            'units' => $this->ddlUnits()
        ]);
    }
    public function saveProduct():void
    {
        if($this->isEdit){
            $sw1 = $this->form->update($this->getProduct($this->product_id));
            $title = 'Producto actualizada';
            $icon = 'success';
            $message = 'Producto actualizada correctamente';
            $this->isEdit = false;
        }else{
            $sw2 = $this->form->store();
            $title = 'Producto guardada';
            $icon = 'success';
            $message = 'Producto guardada correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editProduct($product_id):void
    {
        $this->form->show($this->getProduct($product_id));
        $this->isEdit = true;
        $this->product_id = $product_id;
    }
    public function deleteProduct($product_id):void
    {
        $this->form->delete($product_id);
    }
    public function exportFile()
    {
        return $this->exportFileProducts();
    }
    public function buscar()
    {

    }
}
