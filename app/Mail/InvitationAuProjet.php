<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationAuProjet extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $projet;
    public $lienInvitation;
    public $fonction;

    public function __construct($projet, $lienInvitation, $fonction)
    {
        $this->projet = $projet;
        $this->lienInvitation = $lienInvitation;
        $this->fonction=$fonction;
    }

    public function build()
    {
        return $this->subject('Invitation à rejoindre le projet : ' . $this->projet->titre)
                    ->view('projet.invitation')
                    ->with([
                        'titre' => $this->projet->titre,
                        'lienInvitation' => $this->lienInvitation,
                        'fonction'=>$this->fonction
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation Au Projet',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'projet.invitation',
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
