<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        dump("Ça fucntion");
        die();
    }

    /**
     * @Route("/test", name ="test");
     */
    public function test()
    {
        dd("Hello from test");
    }
}
