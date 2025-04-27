<?php
namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Audit;
use App\Entity\Employe;
use App\Entity\Project;
use Symfony\Component\Security\Core\Security;

class DoctrineAuditoriaSubscriber implements EventSubscriber
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function getSubscribedEvents(): array
    {
        return ['postPersist', 'postUpdate', 'postRemove'];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->audit($args, 'CREATE');
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->audit($args, 'UPDATE');
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->audit($args, 'DELETE');
    }

    private function audit(LifecycleEventArgs $args, string $action)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Employe && !$entity instanceof Project) {
            return;
        }

        $user = $this->security->getUser();

        $audit = new Audit();
        $audit->setUser($user ? $user->getUserIdentifier() : 'anon.');
        $audit->setAffectedEntity((new \ReflectionClass($entity))->getShortName());
        $audit->setActionType($action);
        $audit->setDateTime(new \DateTimeImmutable());

        $entityManager->persist($audit);
        $entityManager->flush();
    }
}
