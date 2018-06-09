<?php


namespace App\Service;


use App\Entity\Participant;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ParticipantAuthenticator
{

    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;


    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    public function loginAs(Participant $participant):void
    {
        $token = new UsernamePasswordToken($participant, $participant->getPassword(), 'participant', $participant->getRoles());
        $this->tokenStorage->setToken($token);


        $this->authenticationManager->authenticate($token);

    }
}