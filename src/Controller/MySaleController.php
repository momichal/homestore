<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MySaleController extends Controller
{
    /**
     * @Route("/my/sale/index", name="my_sale_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $sales = $entityManager
            ->getRepository(Sale::class)
            ->findBy(["owner" => $this->getUser()]);

        return $this->render("MySale/index.html.twig", ["sales" => $sales]);
    }

    /**
     * @Route("/my/sale/details/{id}", name="my_sale_details")
     *
     * @param Sale $sale
     *
     * @return Response
     */
    public function detailsAction(Sale $sale)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($sale->getStatus() === Sale::STATUS_FINISHED){
            return $this->render("MySale/finished.html.twig", ["sale" => $sale]);
        }

        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("my_sale_delete", ["id" => $sale->getId()]))
            ->setMethod(Request::METHOD_DELETE)
            ->add("submit", SubmitType::class, ["label" => "Usuń"])
            ->getForm();

        $finishForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("my_sale_finish", ["id" => $sale->getId()]))
            ->add("submit", SubmitType::class, ["label" => "Zakończ"])
            ->getForm();

        return $this->render("MySale/details.html.twig",
            [
                "sale" => $sale,
                "deleteForm" => $deleteForm->createView(),
                "finishForm" => $finishForm->createView(),
            ]
        );
    }

    /**
     * @Route("/my/sale/add", name="my_sale_add")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $sale = new Sale();

        $form = $this->createForm(SaleType::class, $sale);

        if($request->isMethod("post")){
            $form->handleRequest($request);

            if($form->isValid()){
                $sale
                    ->setStatus(Sale::STATUS_ACTIVE)
                    ->setOwner($this->getUser());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($sale);
                $entityManager->flush();

                $this->addFlash("success", "Przedmiot {$sale->getTitle()} został dodany!");

                return $this->redirectToRoute("my_sale_details", ["id" => $sale->getId()]);
            }

            $this->addFlash("error", "Nie udało się dodać przedmiotu!");
        }

        return $this->render("MySale/add.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/my/sale/edit/{id}", name="my_sale_edit")
     *
     * @param Request $request
     * @param Sale $sale
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Sale $sale)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $sale->getOwner()){
            throw new AccessDeniedException();
        }

        $form = $this->createForm(SaleType::class, $sale);

        if($request->isMethod("post")) {
            $form->handleRequest($request);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sale);
            $entityManager->flush();

            $this->addFlash("success", "Przedmiot {$sale->getTitle()} został zaktualizowany");

            return $this->redirectToRoute("my_sale_details", ["id" => $sale->getId()]);
        }

        return $this->render("MySale/edit.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/my/sale/delete/{id}", name="my_sale_delete", methods={"DELETE"})
     *
     * @param Sale $sale
     *
     * @return RedirectResponse
     */
    public function deleteAction(Sale $sale)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $sale->getOwner()){
            throw new AccessDeniedException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($sale);
        $entityManager->flush();

        $this->addFlash("success", "Przedmiot {$sale->getTitle()} został usunięty!");

        return $this->redirectToRoute("my_sale_index");
    }

    /**
     * @Route("/my/sale/finish/{id}", name="my_sale_finish", methods={"POST"})
     *
     * @param Sale $sale
     *
     * @return RedirectResponse
     */
    public function finishAction(Sale $sale)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $sale->getOwner()){
            throw new AccessDeniedException();
        }

        $sale
            ->setExpiresAt(new \DateTime())
            ->setStatus(Sale::STATUS_FINISHED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($sale);
        $entityManager->flush();

        $this->addFlash("success", "Sprzedaż przedmiotu {$sale->getTitle()} została zakończona");

        return $this->redirectToRoute("my_sale_details", ["id" => $sale->getId()]);
    }
}