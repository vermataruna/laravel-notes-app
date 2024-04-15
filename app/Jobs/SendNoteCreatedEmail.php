<?php

namespace App\Jobs;

use App\Mail\NoteCreated;
use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNoteCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $note;

    public function __construct(User $user, Note $note)
    {
        $this->user = $user;
        $this->note = $note;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new NoteCreated($this->note));
    }
}
