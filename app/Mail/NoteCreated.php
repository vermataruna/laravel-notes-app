<?php

namespace App\Mail;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Note $note
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A new note created!'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.notes.noteCreated',
        );
    }
}
