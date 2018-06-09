<?php


namespace App\Controller;


use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/")
 */
class EntryPoint extends Controller
{

    /**
     * @var TwigEngine
     */
    private $twig;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(Environment $twig, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    /**
     * @throws \Twig\Error\Error
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke():Response
    {
        if($this->hasAlreadyParticipated()) {
            return new Response($this->twig->render('thanks.html.twig'));
        }

        return new Response($this->twig->render('entry.html.twig'));
    }

    private function hasAlreadyParticipated():bool
    {
        return $this->session->has('participant_id');
    }
}