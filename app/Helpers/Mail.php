<?php

namespace App\Helpers;

use App\User;
use SendGrid;
use SendGrid\Content;
use SendGrid\Email;
use function env;
use function is_array;
use function str_random;

class Mail
{
    private $to;
    private $from;
    private $subject;
    private $body;
    private $type = "text/html";
    private $email;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setTo([
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $this->setFrom([
            'name' => env("EMAIL_FROM_NAME", 'Admin'),
            'email' => env("EMAIL_FROM_EMAIL", 'no-reply') . '@' . env('APP_DOMAIN'),
        ]);
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public static function init(User $user)
    {
        return new self($user);
    }

    public function send()
    {

        if (is_array($this->from)) {
            $from_name = $this->from['name'];
            $from_email = $this->from['email'];
        } else {
            $from_name = null;
            $from_email = $this->from;
        }
        $from = new Email($from_name, $from_email);

        if (is_array($this->to)) {
            $to_name = $this->to['name'];
            $to_email = $this->to['email'];
        } else {
            $to_name = null;
            $to_email = $this->to;
        }

        $to = new Email($to_name, $to_email);

        $subject = $this->subject;

        $content = new Content($this->type, $this->body);

        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = env('SENDGRID_KEY');
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);

        return $response;
    }

    public function passwordReset()
    {
        $link = $this->user->generatePasswordResetlink();

        $body = "<p>" . "Please " . "<a href='" . $this->user->generatePasswordResetlink() . "' target='_new'>" . "click here" . "</a>";
        $body .= " or use the below link to change your password" . "</p>";
        $body .= "<p>" . "<a href='" . $this->user->generatePasswordResetlink() . "' target='_new'>" . $link . "</a>";
        $body .= "<p>" . "Thank you" . "</p>";

        $this->setSubject('Password Reset for ' . env('APP_NAME'));
        $this->setBody($body);

        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $this->type === "text/plain" ? $body :

            "<html><head><title>" . $this->subject . "</title></head><body>Hello " . "<strong>" . $this->user->name . "</strong>" . $body . "</body></html>";
        return $this;
    }

    public function sendNewPassword($password = NULL)
    {
        $body = "<p>" . "Password reset complete." . "</p>";
        $body .= "<p>" . "New Password: " . $this->user->changePassword($password ?? str_random('8')) . '</p>';
        $body .= "<p>" . "Thank you" . "</p>";

        $this->setSubject('Password Reset for ' . env('APP_NAME'));
        $this->setBody($body);

        $this->user->updatePasswordResetToken();

        return $this;
    }
}