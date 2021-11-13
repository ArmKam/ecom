<?php

namespace App\Controller;

use App\Taxes\Calculator;
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
    public function test(Request $request, $age, Calculator $calculator)
    {
        // $age = $request->attributes->get("age");

        //dump($request);
        $tva = $calculator->calcul(111);
        dump($tva);
        // dd("Hello from test $age");

        return  new Response("Vous avez $age ans");
    }
}
