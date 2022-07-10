<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $authentication_code)
    {
        $this->email = $email;
        $this->authentication_code = $authentication_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->email)
            ->subject('メールアドレスの認証コード')
            ->view('emails/emailRegistration')
            ->with([
                'email' => $this->email,
                'auth_code' => $this->authentication_code
            ]);
    }
}
