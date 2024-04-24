<?php

namespace App\Contact;

use App\Dto\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMailSender
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    public function sendContactMail(Contact $contact): void
    {
        $contact->setCreatedAt(new \DateTimeImmutable());
        $email = (new Email())
            ->addTo('admin@sensiotv.com')
            ->subject(sprintf('New contact form message: "%s"', $contact->getSubject()))
            ->addFrom($contact->getEmail())
            ->text(sprintf('From %s at %s: "%s"',
                $contact->getName(),
                $contact->getCreatedAt()->format('d M Y'),
                $contact->getContent()
            ));

        $this->mailer->send($email);
    }
}
