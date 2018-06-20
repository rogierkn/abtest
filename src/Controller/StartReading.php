<?php


namespace App\Controller;

use App\Entity\Participant;
use App\Service\ParticipantCreator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/start", name="start-reading", methods={"POST", "GET"})
 */
class StartReading
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ParticipantCreator
     */
    private $participantCreator;

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        SessionInterface $session,
        ParticipantCreator $participantCreator,
        Environment $twig,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->participantCreator = $participantCreator;
        $this->twig = $twig;
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function __invoke(): Response
    {
//        if (!$this->session->has('participant_id')) {
            $participant = $this->participantCreator->createParticipant($this->request->get('age', 0));
            $this->session->set('participant_id', $participant->getId());
//        } else {
//            $participant = $this->entityManager->getRepository('App:Participant')->find($this->session->get('participant_id'));
//        }

        $this->startReading($participant);

        return new Response($this->twig->render('read.html.twig', ['participant' => $participant]));
    }

    private function startReading(Participant $participant): void
    {
        $participant->setStartTime(new \DateTime());

        $this->entityManager->persist($participant);
        $this->entityManager->flush();
    }
}
