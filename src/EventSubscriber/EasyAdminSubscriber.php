<?php

namespace App\EventSubscriber;

use App\Entity\Client;
use App\Entity\Entreprise;
#use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EasyAdminSubscriber  implements EventSubscriberInterface
{

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['addUser'],
            AfterEntityUpdatedEvent::class => ['after'],
            BeforeEntityUpdatedEvent::class => ['updateUser'],
            // BeforeEntityUpdatedEvent::class => ['updateActiveAttemptEntreprise'],
        ];
    }


    public function after(AfterEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
    }


    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $this->setPassword($entity);
    }

    public function addUser(BeforeEntityPersistedEvent $event)
    {
        dump("jack live");
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $this->setPassword($entity);
        $entity->setRoles(['ROLE_ADMIN']);
    }


    /**
     * @param User $entity
     */
    public function setPassword(User $entity): void
    {
        $pass = $entity->getPassword();

        $entity->setPassword(
            $this->passwordEncoder->hashPassword(
                $entity,
                $pass
            )
        );
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    // public function updateActiveAttemptEntreprise(BeforeEntityUpdatedEvent $event, SessionInterface $session)
    // {

    //     $entity = $event->getEntityInstance();



    //     if (!($entity instanceof Entreprise) || $entity->getActive() == true) {
    //         return;
    //     }
    //     $this->setActiveAttemptEntreprise($entity);
    // }

    // public function setActiveAttemptEntreprise(Entreprise $entity)
    // {
    //     $entity->setActive(true);
    //     $this->entityManager->persist($entity);
    //     $this->entityManager->flush();
    // }
}
