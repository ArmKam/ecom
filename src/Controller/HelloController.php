<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{

    // protected $logger;
    // public function __construct(LoggerInterface $logger)
    // {

    //     $this->logger = $logger;
    // }
    /**
     * @Route("/hello/{prenom<[a-zA-Z]+>?World}",  name="hello")
     */
    public function hello(LoggerInterface $logger, $prenom)
    {


        // dump($request);
        // $this->logger->info("This log created by $prenom");
        $logger->info("This log created by $prenom");

        return new Response("Hello $prenom");
    }
}
