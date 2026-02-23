<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasscodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $documentName;

    /**
     * Create a new message instance.
     */
    public function __construct($url, $documentName)
    {
        $this->url = $url;
        $this->documentName = $documentName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Reset Passcode Dokumen',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Gunakan 'view' bukan 'markdown'
            view: 'emails.reset-passcode', 
            with: [
                'url' => $this->url,
                'documentName' => $this->documentName,
                // Tambahkan data user jika template membutuhkannya
                'userName' => auth()->user()->name ?? 'Pengguna', 
            ],
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
