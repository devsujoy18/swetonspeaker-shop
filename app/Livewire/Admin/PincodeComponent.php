<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pincode;

class PincodeComponent extends Component
{
    use WithPagination;
    public $search = '';
    public $modalOpen = false;
    public $isEdit = false;

    public $pincodeId;
    public $scrcd, $region, $state, $pin_code;
    public $is_active = true;

    protected function rules()
    {
        return [
            'scrcd'    => 'nullable',
            'region'   => 'nullable',
            'state'    => 'nullable',
            'pin_code' => 'required|digits:6|unique:pincodes,pin_code,' . $this->pincodeId,
        ];
    }

    public function save()
    {
        $this->validate();

        Pincode::updateOrCreate(
            ['id' => $this->pincodeId],
            [
                'scrcd'     => $this->scrcd,
                'region'    => $this->region,
                'state'     => $this->state,
                'pin_code'  => $this->pin_code,
                'is_active' => $this->is_active,
            ]
        );

        $this->modalOpen = false;
        $this->dispatch('notify', message: 'Pincode saved successfully');
    }

    public function resetFilters(){
        $this->search = '';
    }

    public function openModal($id = null){
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $p = Pincode::findOrFail($id);
            $this->pincodeId = $p->id;
            $this->scrcd     = $p->scrcd;
            $this->region    = $p->region;
            $this->state     = $p->state;
            $this->pin_code  = $p->pin_code;
            $this->is_active = $p->is_active;
            $this->isEdit    = true;
        }

        $this->modalOpen = true;
    }

    public function resetForm()
    {
        $this->reset(['pincodeId','scrcd','region','state','pin_code','is_active','isEdit']);
        $this->is_active = true;
    }

    public function toggleStatus($id)
    {
        $p = Pincode::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);
    }

    public function render()
    {
        $pincodes = Pincode::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('pin_code', 'like', '%' . $this->search . '%')
                      ->orWhere('region', 'like', '%' . $this->search . '%')
                      ->orWhere('state', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);
        return view('livewire.admin.pincode-component', [
            'pincodes' => $pincodes
        ]);
    }
}
