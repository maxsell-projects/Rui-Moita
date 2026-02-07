<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class RecruitmentSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova Candidatura de Recrutamento: ' . $this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recruitment-submitted',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->data['cv']->getRealPath())
                ->as($this->data['name'] . '_CV.pdf')
                ->withMime('application/pdf'),
        ];
    }
}