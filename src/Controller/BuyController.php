<?php

namespace App\Controller;

use App\Entity\Buy;
use App\Entity\Sale;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class BuyController extends Controller
{
    /**
     * @Route("/sale/buy/{id}", name="buy_buy", methods={"POST"})
     *
     * @param Sale $sale
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function buyAction(Sale $sale)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $buy = new Buy();
        $buy
            ->setSale($sale)
            ->setOwner($this->getUser())
            ->setPrice($sale->getPrice());

        $sale
            ->setStatus(Sale::STATUS_FINISHED)
            ->setExpiresAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($sale);
        $entityManager->persist($buy);
        $entityManager->flush();

        $this->addFlash("success", "Kupiłeś przedmiot {$sale->getTitle()} za kwotę {$buy->getPrice()} zł");

        return $this->redirectToRoute("sale_details", ["id" => $sale->getId()]);
    }
}