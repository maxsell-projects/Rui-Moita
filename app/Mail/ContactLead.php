<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // 1. Importar a interface
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactLead extends Mailable implements ShouldQueue // 2. Implementar a interface
{
    use Queueable, SerializesModels;

    /**
     * O número de vezes que a tarefa pode ser tentada.
     */
    public $tries = 3;

    /**
     * O número de segundos a aguardar antes de tentar novamente.
     */
    public $backoff = 60;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo Contacto: ' . ($this->data['subject'] ?? 'Website Diogo Maia'),
            replyTo: [$this->data['email']]
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
        );
    }
}