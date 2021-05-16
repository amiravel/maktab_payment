<?php

namespace App\Http\Livewire;

use App\Models\Refund;
use App\QueryFilters\RefundFilters;
use Livewire\Component;
use Livewire\WithPagination;

class RefundSearch extends Component
{
    use WithPagination;

    public $search = [];

    protected $queryString = ['search'];

    public function render()
    {
        $filters = RefundFilters::hydrate($this->search);
        $refunds = Refund::filterBy($filters)->latest()->paginate();

        return view('livewire.refund-search', compact('refunds'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
