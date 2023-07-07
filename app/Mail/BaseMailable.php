<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BaseMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array|mixed
     */
    public mixed $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->theme = get_domain();
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope();
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {

        return new Content(
            markdown: 'emails.'.$this->view,
            with: [
                'data' => $this->data,
                'subcopy' => 'plkaokok'
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
