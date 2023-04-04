<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Security\EmailVerifier;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;

class UserSubscriber implements EventSubscriberInterface
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function onAfterEntityPersistedEvent(AfterEntityPersistedEvent $event): void
    {
        $user = $event->getEntityInstance();

        if (!($user instanceof User) || $user->isVerified()) {
            return;
        }

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('iwa.gaming@outlook.com', 'IWA Mail Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => 'onAfterEntityPersistedEvent',
        ];
    }
}
