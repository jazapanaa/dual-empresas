<?php

namespace App\Livewire\Admin;

use App\Http\Traits\SettingsTrait;
use Livewire\Component;

class ModulesSettingsLive extends Component
{
    use SettingsTrait;
    public array $modules = [];
    public function render()
    {
        return view('livewire.admin.modules-settings-live');
    }
    public function mount()
    {
        $this->modules = $this->getModulesSettings()->get()->toArray();
    }
    public function save()
    {
        $this->setModuleSetting($this->modules);
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => __('Módulos actualizados correctamente'),
        ]);
    }
}
