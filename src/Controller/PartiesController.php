<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\AddPartyType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartiesController extends AbstractController
{
    /**
     * @Route("/parties", name="app_parties")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $param=$_GET['param']??null;
        $data=$doctrine->getRepository(Party::class)->findAll();

        return $this->render("parties/parties.html.twig", [
            'title'=>'Party site',
            'param'=>$param,
            'row'=>$data
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/add", name="app_add")
     */
    public function addParty(ManagerRegistry $doctrine, Request $request):Response
    {
        $party=new Party();
        $form=$this->createForm(AddPartyType::class, $party);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $party=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('app_parties', ['param'=>'Adding successful!']);
        }
        return $this->renderForm('parties/addParty.html.twig',['form'=>$form, 'title'=>'Create new parties']);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     * @Route ("/party", name="app_party")
     */
    public function party(Request $request,ManagerRegistry $doctrine):Response{
        $id=$request->query->get('id');
        $party=$doctrine->getRepository(Party::class)->findBy(['id'=>$id]);
        return $this->render('parties/party.html.twig', ['party'=>$party[0]]);
    }
}