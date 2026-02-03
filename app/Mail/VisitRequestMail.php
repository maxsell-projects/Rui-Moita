<?php

namespace App\Mail;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $property;
    public $data;

    public function __construct(Property $property, array $data)
    {
        $this->property = $property;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Nova Solicitação de Visita: ' . $this->property->title)
                    ->view('emails.visit-request');
    }
}