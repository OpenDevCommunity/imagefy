<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public $link;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param $link
     */
    public function __construct($email, $link)
    {
        $this->email = $email;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.inviteAccepted', [
            'email' => $this->email,
            'link' => $this->link
        ])->subject('MD Share Invite Accepted');
    }
}
