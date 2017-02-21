<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $temp = $em->getRepository("TermostatoBundle:Temp")->findAll();


        return $this->render('TermostatoBundle:Default:index.html.twig');
    }

    public function insertTempAction(Request $request)
    {
        var_dump($request->getClientIp());
       die();
    }

    public function insertHumAction(Request $request)
    {

    }
}
