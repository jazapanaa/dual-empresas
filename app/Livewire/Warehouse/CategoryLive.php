<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\CategoryTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\CategoryForm;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryLive extends Component
{
    use CategoryTrait, DdlTrait, WithPagination;
    public CategoryForm $form;
    public bool $isEdit = false;
    public int $category_id;
    public function render()
    {
        return view('livewire.warehouse.category-live',[
            'categories' => $this->getCategories()->paginate(50),
        ]);
    }
    public function saveCategory():void
    {
        if($this->isEdit){
            $this->form->update($this->getCategory($this->category_id));
            $title = 'Categoría actualizada';
            $icon = 'success';
            $message = 'Categoría actualizada correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Categoría guardada';
            $icon = 'success';
            $message = 'Categoría guardada correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editCategory($category_id):void
    {
        $this->form->show($this->getCategory($category_id));
        $this->isEdit = true;
        $this->category_id = $category_id;
    }
    public function deleteCategory($category_id):void
    {
        $this->form->delete($category_id);
    }

}
