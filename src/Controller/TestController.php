<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/test/{age<\d+>?0}", name ="test", host="localhost", methods={"GET", "POST"},
     * schemes={"http","https"});
     */
    public function test(Request $request, $age)
    {
        // $age = $request->attributes->get("age");

        dump($request);
        // dd("Hello from test $age");

        return  new Response("Vous avez $age ans");
    }
}
