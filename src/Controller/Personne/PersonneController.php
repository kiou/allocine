<?php

namespace App\Controller\Personne;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Personne\Personne;
use App\Form\Personne\PersonneType;
use App\Utilities\Recherche;
use Knp\Component\Pager\PaginatorInterface;

class PersonneController extends Controller{

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $personne = new Personne;
        $form = $this->createForm(PersonneType::class, $personne);
        
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($personne);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'acteur/réalisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_personne_manager'));
        }

        return $this->render('Personne/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function managerAdmin(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {
        /* Services */
        $recherches = $recherche->setRecherche('peronne_manager', array(
            'recherche'
            )
        );

        /* La liste des personnes */
        $personnes = $this->getDoctrine()
                          ->getRepository(Personne::class)
                          ->getAllPersonnes($recherches['recherche']);
        $pagination = $paginator->paginate(
            $personnes, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        return $this->render('Personne/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'recherches' => $recherches
            )
        );
    }

     /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Personne $personne)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();
        $request->getSession()->getFlashBag()->add('succes', 'acteur/réalisateur supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_personne_manager'));
    }

     /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Personne $personne)
    {
        $form = $this->createForm(PersonneType::class, $personne);
        
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($personne);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'acteur/réalisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_personne_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des acteurs/réaliateurs' => $this->generateUrl('admin_personne_manager'),
            'Modifier un acteur/réalisateur' => ''
        );

        return $this->render('Personne/Admin/modifier.html.twig',
            array(
                'form' => $form->createView(),
                'personne' => $personne,
                'breadcrumb' => $breadcrumb
            )
        );
    }

     /**
     * Fiche persso,,e
     */
    public function ClientView($slug, Personne $personne){

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('client_page_index'),
            $personne->getPrenom().' '.$personne->getNom()  => ''
        );

        return $this->render( 'Personne/view.html.twig',array(
            'personne' => $personne,
            'breadcrumb' => $breadcrumb
            )
        );

    }

}

?>