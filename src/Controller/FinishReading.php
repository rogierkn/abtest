<?php


namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/finish", name="finish-reading")
 */
class FinishReading
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke():Response
    {
        $participant = $this->entityManager->getRepository('App:Participant')->find($this->session->get('participant_id'));

        if($participant !== null) {
            $this->finishedReading($participant);
        }

        return new Response($this->twig->render('thanks.html.twig'));
    }

    private function finishedReading(Participant $participant): void
    {
        $participant->setEndTime(new \DateTime());

        $this->entityManager->persist($participant);
        $this->entityManager->flush();
    }
}
