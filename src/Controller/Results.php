<?php


namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/resultaatjes", name="results")
 */
class Results
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke()
    {
        $participants = $this->entityManager->getRepository('App:Participant')->findAll();
        $participants = array_filter($participants, function (Participant $participant) {
            return !($participant->getStartTime() === null || $participant->getEndTime() === null);
        });


        return new Response($this->twig->render(
            'results.html.twig',
            [
                'participants' => array_reverse($participants),
                'a'            => ['age'      => $this->avgAge($this->group('A', $participants)),
                                   'duration' => $this->avgDuration($this->group('A', $participants)),
                ],
                'b'            => ['age'      => $this->avgAge($this->group('B', $participants)),
                                   'duration' => $this->avgDuration($this->group('B', $participants)),
                ],
            ]
        ));
    }

    private function group(string $group, array $participants): array
    {
        return array_filter($participants, function (Participant $participant) use ($group) {
            return $participant->getGroup() === $group;
        });
    }

    private function avgAge(array $participants): int
    {
        return array_reduce($participants, function ($sum, Participant $participant) {
            $sum += $participant->getAge();

            return $sum;
        }, 0);
    }

    private function avgDuration(array $participants): int
    {
        return array_reduce($participants, function ($sum, Participant $participant) {
            $sum += $participant->getDuration();

            return $sum;
        }, 0);
    }
}
