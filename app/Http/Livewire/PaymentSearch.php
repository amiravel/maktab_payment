<?php

namespace App\Http\Livewire;

use App\Models\Drive;
use App\Models\Payment;
use App\Models\Tag;
use App\QueryFilters\PaymentFilters;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentSearch extends Component
{
    use WithPagination;

    public $search = [];

    protected $queryString = ['search'];

    public function render()
    {
        $filters = PaymentFilters::hydrate($this->search);
        $payments = Payment::filterBy($filters)->latest()->paginate();

        $drives = Drive::pluck('name', 'id');

        $tags = Tag::query()
            ->whereNotNull('parent')
            ->get()
            ->groupBy('parent')
            ->flatten(1);

        return view('livewire.payment-search', compact('payments', 'drives', 'tags'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
