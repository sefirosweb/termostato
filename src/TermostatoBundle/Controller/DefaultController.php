<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TermostatoBundle\Entity\Date;
use TermostatoBundle\Entity\Hum;
use TermostatoBundle\Entity\Temp;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*$qb = $em->createQueryBuilder()
            ->select('d')
            ->from('TermostatoBundle:Date', 'd')
            ->getQuery()
            ->getResult();*/

        return $this->render('TermostatoBundle:Default:index.html.twig');
    }

    private function getData()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dataRaws = $em->getRepository('TermostatoBundle:Date')->findAll();
        foreach ($dataRaws as $dataRaw) {
            $data[] = array(
                'date' => $dataRaw->getDatetime()->format('Y-m-d H:i:s'),
                'temp' => $dataRaw->getTemp()->getTemp(),
                'hum' => $dataRaw->getHum()->getHum()
            );
        }
        return $data;
    }

    public function getAjaxDataAction(){
        $normalizer = new ObjectNormalizer(null);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));

        $data = $this->getData();
        return $this->responeJSON($data);
    }

    private function responeJSON($data)
    {
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
