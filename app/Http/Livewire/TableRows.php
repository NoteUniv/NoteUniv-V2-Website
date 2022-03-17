<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TableRows extends Component
{
    public $data;
    public $increment = 5;
    public $max = 0;
    public $isAtMax = false;
    public $template;

    protected $listeners = ['showMore'];

    public function mount()
    {
        $this->max = $this->increment;
    }

    public function showMore()
    {
        $this->max = $this->max + $this->increment;
        $this->dispatchBrowserEvent('show-more');
    }

    public function render()
    {
        $rows = array_slice($this->data, 0, $this->max);
        if ($this->max + $this->increment > count($this->data)) {
            $this->isAtMax = true;
        }
        return view('livewire.table-rows', ['rows' => $rows, 'template' => $this->template, 'isAtMax' => $this->isAtMax]);
    }
}