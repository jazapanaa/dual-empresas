<?php

namespace App\Livewire\Users;

use App\Http\Traits\AuditTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLive extends Component
{
    use AuditTrait,WithPagination;
    public function render()
    {
        return view('livewire.users.audit-live',[
            'audits' => $this->getActivities()->paginate(10),
        ]);
    }
}
