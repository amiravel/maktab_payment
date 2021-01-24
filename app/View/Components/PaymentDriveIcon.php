<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PaymentDriveIcon extends Component
{
    protected $drive;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($drive)
    {
        $this->drive = $drive;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.payment-drive-icon')
            ->with('drive', $this->drive);
    }
}
