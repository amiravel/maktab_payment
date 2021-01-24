<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PaymentStatusIcon extends Component
{
    protected $status;

    /**
     * Create a new component instance.
     *
     * @param bool $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.payment-status-icon')
            ->with('status', $this->status);
    }
}
