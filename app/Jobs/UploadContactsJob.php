<?php

namespace App\Jobs;

use App\Models\Contatos;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadContactsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    protected $file;
    protected $user_id;

    public function __construct($user_id, $file)
    {

        $this->file = $file;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $path = $this->file->store('uploads');

        $file = fopen(storage_path('app/' . $path), 'r');

        while (($line = fgetcsv($file)) !== FALSE) {

            $contato = new Contatos();
            $contato->name = $line[0];
            $contato->number = $line[1];
            $contato->tag_id = $line[2];
            $contato->user_id = $this->user_id;
            $contato->save();
        }

        fclose($file);

    }
}
