<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Save the Date! Tiket Prom Night Kamu Ada di Sini 📅',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.ticket',
        );
    }

    /**
     * Build the email with custom headers.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('mail.ticket')
            ->with(['data' => $this->data])
            ->withSwiftMessage(function ($message) {
                $headers = $message->getHeaders();
                $headers->addTextHeader('X-Priority', '1'); // Priority tertinggi
                $headers->addTextHeader('Importance', 'high'); // Ditandai sebagai penting
            });
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}