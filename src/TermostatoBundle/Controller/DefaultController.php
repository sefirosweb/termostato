<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TermostatoBundle\Entity\Hum;
use TermostatoBundle\Entity\Temp;

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
        $temp = new Temp();
        $temp->setTemp($request->get('temp'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($temp);

        $em->flush();

        return new Response('ID: ' . $temp->getId() . ' Temp: ' . $temp->getTemp() . ' Date: ' . $temp->getDate()->format('Y-m-d H:i:s'));
    }

    public function insertHumAction(Request $request)
    {
        $hum = new Hum();
        $hum->setHum($request->get('hum'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($hum);

        $em->flush();

        return new Response('ID: ' . $hum->getId() . ' Hum: ' . $hum->getHum() . ' Date: ' . $hum->getDate()->format('Y-m-d H:i:s'));
    }

    public function insertBothAction(Request $request)
    {
        $hum = $this->insertHumAction($request);
        $temp = $this->insertTempAction($request);
        return new Response($temp->getContent() . '<br>' . $hum->getContent());
    }
}
