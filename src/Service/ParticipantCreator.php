<?php


namespace App\Service;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ParticipantCreator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /** @var Request  */
    private $request;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * @throws \Exception
     */
    public function createParticipant(int $age): Participant
    {
        $participant = new Participant();
        $participant->setName(md5(date('h-i-s ddmmyyyy')));
        $participant->setAge($age);
        $participant->setIp($this->request->getClientIp());

        $group = mt_rand(0, 1) < 0.5 ? 'A' : 'B';
        if($this->request->get('group', null) !== null) {
            $group = $this->request->get('group');
        }

        $participant->setGroup($group);


        $this->entityManager->persist($participant);
        $this->entityManager->flush();

        return $participant;
    }
}
