<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Control;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateControlStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-control-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates control status based on date range';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now();

        Control::chunk(100, function ($controls) use ($currentDate) {
            foreach ($controls as $control) {
                $control->is_active = $currentDate->between($control->tanggal_mulai, $control->tanggal_berakhir);
                
                if (!$control->is_active) {
                    $control->isguestactive = false;
                }

                $control->save();
            }
        });

        Log::info('Control statuses updated successfully at ' . $currentDate);
    }
}