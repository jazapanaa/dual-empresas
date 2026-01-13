<?php

namespace App\Livewire\Admin;

use App\Http\Traits\SettingsTrait;
use Livewire\Component;

class SidebarLive extends Component
{
    use SettingsTrait;

    public function render()
    {
        return view('livewire.admin.sidebar-live', [
            'modules' => $this->getModulesArray(),
        ]);
    }
}
