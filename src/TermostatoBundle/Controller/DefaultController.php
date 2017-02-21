<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TermostatoBundle:Default:index.html.twig');
    }

    public function insertTempAction(){

    }

    public function insertHumAction(){

    }
}
