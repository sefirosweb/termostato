<?php

namespace TermostatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TermostatoBundle\Entity\Date;
use TermostatoBundle\Entity\Hum;
use TermostatoBundle\Entity\Temp;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TermostatoBundle:Default:index.html.twig', array('dataChart' => $this->getGoogleChartInfo()));
    }

    private function getData($limit = 100)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dataRaws = $em->createQueryBuilder()
            ->select('d')
            ->from('TermostatoBundle:Date', 'd')
            ->orderBy('d.datetime', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        foreach ($dataRaws as $dataRaw) {
            $data[] = array(
                'date' => $dataRaw->getDatetime()->format('Y-m-d H:i:s'),
                'temp' => $dataRaw->getTemp()->getTemp(),
                'hum' => $dataRaw->getHum()->getHum()
            );
        }
        return $data;
    }

    private function getGoogleChartInfo($limit = 100)
    {
        $datas = $this->getData($limit);

        //Google char table array
        $table = array();
        $table['cols'] = array(
            array('id' => "", 'label' => 'Date', 'pattern' => "", 'type' => 'string'),
            array('id' => "", 'label' => 'Temperature', 'pattern' => "", 'type' => 'number'),
            array('id' => "", 'label' => 'Humedity', 'pattern' => "", 'type' => 'number')
        );
        $rows = array();
        foreach ($datas as $data) {
            $temp = array();
            $temp[] = array('v' => $data['date'], 'f' => NULL);
            $temp[] = array('v' => $data['temp'], 'f' => NULL);
            $temp[] = array('v' => $data['hum'], 'f' => NULL);
            $rows[] = array('c' => $temp);
        }
        $table['rows'] = $rows;

        return $table;
    }

    public function sendEmailAction(Request $request)
    {
        if (!($request->getClientIp() == '127.0.0.1' || $request->getClientIp() == '::1')) {
            return new Response('You no have authorization');
        }
        $message = \Swift_Message::newInstance()
            ->setSubject("Alerta temperatura del CPD")
            ->setFrom("itteam@westwing.es")
            ->setTo("it.contact@westwing.es")
            ->setContentType("text/html")
            ->setBody(
                $this->renderView(
                    'TermostatoBundle:Default:email.html.twig',
                    array('datas' => $this->getData(20))
                )
            );
        $this->get('mailer')->send($message);
        return new Response("Sended email");
    }

    public function sendEmailViewAction(Request $request)
    {
        return $this->render('TermostatoBundle:Default:email.html.twig', array('datas' => $this->getData(20)));
    }

    public function getAjaxDataAction()
    {
        /*$normalizer = new ObjectNormalizer(null);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));*/

        return $this->responeJSON($this->getGoogleChartInfo($_GET['limit']));
    }

    private function responeJSON($data)
    {
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function insertBothAction(Request $request)
    {
        if (!($request->getClientIp() == '127.0.0.1' || $request->getClientIp() == '::1')) {
            return new Response('You no have authorization');
        }

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
