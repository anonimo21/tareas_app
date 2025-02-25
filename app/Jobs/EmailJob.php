<?php

namespace App\Jobs;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tarea = new Tarea();
        $tarea->nombre = 'Tarea 2';
        $tarea->descripcion = 'Descripcion de la tarea 2';
        $tarea->estado = "1";
        $tarea->save();
    }
}
