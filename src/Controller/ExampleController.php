<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @return Response
     * @Route("/ex/{param}", name="app_example")
     */
    public function index(string $param):Response{
        //$param=$_GET['param']??null;
        return $this->render('example/ex.html.twig', [
            'example'=>'ex',
            'param'=>$param
        ]);
    }
}