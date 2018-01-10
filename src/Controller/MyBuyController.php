<?php

namespace App\Controller;

use App\Entity\Buy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MyBuyController extends Controller
{
    /**
     * @Route("/my/buy", name="my_buy_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $buys = $entityManager
            ->getRepository(Buy::class)
            ->findBy(["owner" => $this->getUser()]);

        return $this->render("MyBuy/index.html.twig", ["buys" => $buys]);
    }
}