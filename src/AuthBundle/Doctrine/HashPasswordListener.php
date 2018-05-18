<?php

namespace AuthBundle\Doctrine;

use AuthBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class HashPasswordListener implements EventSubscriber {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoder $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        } else {
            if (!$entity->getPasswordTemp() && $entity->getPlainPassword()) {
                $this->encodePassword($entity);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        } else {
            if (!$entity->getPasswordTemp() && $entity->getPlainPassword()) {
                $this->encodePassword($entity);
                // necessary to force the update to see the change
                $em = $args->getEntityManager();
                $meta = $em->getClassMetadata(get_class($entity));
                $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
            }
        }
    }

    public function getSubscribedEvents() {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param User $entity
     */
    private function encodePassword(User $entity) {
        if (!$entity->getPlainPassword()) {
            return;
        }
        $encoded = $this->passwordEncoder->encodePassword(
                $entity, $entity->getPlainPassword()
        );
        $entity->setPassword($encoded);
    }

}
