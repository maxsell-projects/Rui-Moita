<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class RecruitmentApplication extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova Candidatura: ' . ($this->data['name'] ?? 'Candidato'),
            replyTo: [$this->data['email']]
        );
    }

    public function content(): Content
    {
        // Podes reutilizar a view de contacto ou criar uma nova 'emails.recruitment'
        return new Content(
            markdown: 'emails.contact', 
            with: [
                'isRecruitment' => true,
            ]
        );
    }

    public function attachments(): array
    {
        // Se o formulário tiver upload de CV
        if (isset($this->data['cv_path'])) {
            return [
                Attachment::fromPath($this->data['cv_path'])
                    ->as('Curriculo.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}