<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencyCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agencyName;
    public $email;
    public $password;
    public $agencyId;

    /**
     * Create a new message instance.
     */
    public function __construct($agencyName, $email, $password, $agencyId)
    {
        $this->agencyName = $agencyName;
        $this->email = $email;
        $this->password = $password;
        $this->agencyId = $agencyId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MCMC Agency Registration - Login Credentials',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agency-credentials',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
