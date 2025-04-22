<?php

namespace App\Observers;

use App\Models\Control;
use Carbon\Carbon;

class ControlObserver
{
    public function saving(Control $control)
    {
        $currentDate = Carbon::now();

        
        if ($currentDate->greaterThanOrEqualTo($control->tanggal_mulai) && $currentDate->lessThanOrEqualTo($control->tanggal_berakhir)) {
            $control->is_active = true;
        } else {
            $control->is_active = false;
        }
    }
}
