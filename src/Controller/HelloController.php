<?php

namespace App\Controller;

use Twig\Environment;
use App\Taxes\Detector;
use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{

    protected $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }
    // protected $logger;
    // public function __construct(LoggerInterface $logger)
    // {

    //     $this->logger = $logger;
    // }
    /**
     * @Route("/hello/{prenom<[a-zA-Z]+>?World}",  name="hello")
     */
    public function hello(LoggerInterface $logger, Slugify $slugify, $prenom, Environment $twig, Detector $detecteur)
    {


        dump($detecteur->detect(101));
        dump($detecteur->detect(10));


        // $slugify  = new Slugify();

        dump($twig);
        //dump($slugify->slugify("Hello Worlds"));
        // dump($request);
        // $this->logger->info("This log created by $prenom");
        //$logger->info("This log created by $prenom");
        $tva = $this->calculator->calcul(100);
        dump($tva);
        $logger->info("an operation is made $tva");
        return new Response("Hello $prenom");
    }
}
