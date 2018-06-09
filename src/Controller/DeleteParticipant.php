<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/del/{id}")
 */
class DeleteParticipant
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(int $id)
    {
        $participant = $this->entityManager->getRepository('App:Participant')->find($id);
        $this->entityManager->remove($participant);
        $this->entityManager->flush();

        return new RedirectResponse('/resultaatjes');
    }
}
