<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailUser extends Mailable
{
    use Queueable, SerializesModels;

    private $client;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\stdClass $client)
    {
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nota não fiscal - Teresina Imports');
        $this->to($this->client->email, $this->client->name);
        return $this->markdown('mail.nota', [
            'user' => $this->client
        ]);
    }
}
