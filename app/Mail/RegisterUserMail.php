<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email = null;
    public $password = null;
    public $link = null;

    public function __construct($email, $password, $link)
    {
        $this->email = $email;
        $this->password = $password;
        $this->link = $link;
    }

    public function build()
    {
        return $this->view('mails.user_register', [
            'email' => $this->email,
            'password' => $this->password,
            'link' => $this->link,
        ]);
    }
}
