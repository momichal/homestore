<?php

namespace App\Controller;

use App\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaleController extends Controller
{
    /**
     * @Route("/", name="sale_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $sales = $entityManager->getRepository(Sale::class)->findBy(["status" => Sale::STATUS_ACTIVE]);

        return $this->render("Sale/index.html.twig", ["sales" => $sales]);

    }

    /**
     * @Route("/sale/details/{id}", name="sale_details")
     *
     * @param Sale $sale
     *
     * @return Response
     */
    public function detailsAction(Sale $sale)
    {
        if($sale->getStatus() === Sale::STATUS_FINISHED){
            return $this->render("Sale/finished.html.twig", ["sale" => $sale]);
        }

        $buyForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("buy_buy", ["id" => $sale->getId()]))
            ->add("submit", SubmitType::class, ["label" => "Kup"])
            ->getForm();

        return $this->render("Sale/details.html.twig",
            [
                "sale" => $sale,
                "buyForm" => $buyForm->createView(),
            ]
        );
    }
}