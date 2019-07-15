<?php

namespace App\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Utilities\Recherche;
use App\Form\Contact\ObjetType;
use App\Entity\Contact\Objet;
use App\Entity\General\Langue;

class ObjetController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {

        $objet = new Objet;
        $form = $this->createForm(ObjetType::class, $objet);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Objet enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_contactobjet_manager'));
        }

        return $this->render( 'Contact/Admin/Objet/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );

    }

    /**
     * Gestion
     */
    public function managerAdmin(Recherche $recherche)
    {
        /* Services */
        $recherches = $recherche->setRecherche('contactobjet_manager', array(
                'langue'
            )
        );

        $objets = $this->getDoctrine()
                       ->getRepository(Objet::class)
                       ->getAllObjets($recherches['langue']);

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Contact/Admin/Objet/manager.html.twig',array(
                'objets' => $objets,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Objet $objet)
    {
        if(count($objet->getContacts()) != 0)  throw new NotFoundHttpException('Cette page n\'est pas disponible');

        $em = $this->getDoctrine()->getManager();
        $em->remove($objet);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Objet supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_contactobjet_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Objet $objet)
    {
        $form = $this->createForm(ObjetType::class, $objet);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Objet enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_contactobjet_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des objets' => $this->generateUrl('admin_contactobjet_manager'),
            'Modifier un objet' => ''
        );

        return $this->render('Contact/Admin/Objet/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'objet' => $objet,
                'form' => $form->createView()
            )
        );

    }

}
