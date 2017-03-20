<?php

namespace TotalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('TotalBundle:Default:index.html.twig');
    }

    /**
     * @Route("/contact"  )
     */
    public function contactAction()
    {
        return $this->render('TotalBundle:Default:contact.html.twig');
    }

    /**
     * @Route("/admin/admin"  )
     */
    public function adminAction()
    {
        return $this->render('TotalBundle:Default:admin.html.twig');
    }


     /**
     * @Route("/recherche" )
     */
    public function rechercheAction(Request $request)
    {
        $form = $this->createForm('TotalBundle\Form\RechercheType');
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        // Supprimer la ligne ci dessous si on ne veut pas que les resultats saffichent sans recherche
        $albums = $em->getRepository('TotalBundle:Album')->findAll();


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $albums = $em->getRepository('TotalBundle:Album')->findBy(["titre"=>$data['Recherche']]);
            //return $this->redirectToRoute('recherche');
        }
        return $this->render('TotalBundle:Default:recherche.html.twig', [
            'form'=>$form->createView(),
            'albums'=>$albums,

        ]);

    }
}
