<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('New Contact: ' . ($this->contact->subject ?? 'Website Enquiry'))
                    ->view('emails.contact')
                    ->with([
                        'name'           => $this->contact->name,
                        'email'          => $this->contact->email,
                        'phone'          => $this->contact->phone ?? 'N/A',
                        'subjectText'    => $this->contact->subject ?? 'New query from website',
                        'contactMessage' => $this->contact->message,
                    ]);
    }
}