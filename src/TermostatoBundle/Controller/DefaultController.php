<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TermostatoBundle\Entity\Date;
use TermostatoBundle\Entity\Hum;
use TermostatoBundle\Entity\Temp;
use Doctrine\ORM\Query\Expr\Join;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();



        /*$qb = $em->createQueryBuilder()
            ->select('d')
            ->from('TermostatoBundle:Date', 'd')
            ->getQuery()
            ->getResult();*/

        $data = $em->getRepository('TermostatoBundle:Hum')->findAll();




        return $this->render('TermostatoBundle:Default:index.html.twig', array('data'=>$data));
    }


    public function insertBothAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction(); // suspend auto-commit

        $date = new Date();
        $em->persist($date);
        $em->flush();

        $temp = new Temp();
        $temp->setTemp($request->get('temp'));
        $temp->setDate($date);
        $em->persist($temp);
        $em->flush();

        $hum = new Hum();
        $hum->setHum($request->get('hum'));
        $hum->setDate($date);
        $em->persist($hum);
        $em->flush();


        $em->getConnection()->commit();
        return new Response('Temp: ' . $temp->getTemp() . '<br>Hum: ' . $hum->getHum() . '<br>Date: ' . $temp->getDate()->getDatetime()->format('Y-m-d H:i:s'));
    }
}
