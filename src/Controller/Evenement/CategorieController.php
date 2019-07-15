<?php

namespace App\Controller\Evenement;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Form\Evenement\CategorieType;
use App\Entity\Evenement\Categorie;
use App\Utilities\Recherche;
use App\Entity\General\Langue;

class CategorieController extends Controller
{

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $categorie = new Categorie;
        $form = $this->createForm(CategorieType::class, $categorie);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Catégorie enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_evenementcategorie_manager'));
        }

        return $this->render('Evenement/Admin/Categorie/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Request $request, Recherche $recherche)
    {
        /* Services */
        $recherches = $recherche->setRecherche('evenementcategorie_manager', array(
                'langue'
            )
        );

        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAllCategorie($recherches['langue']);

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Evenement/Admin/Categorie/manager.html.twig',array(
                'langues' => $langues,
                'categories' => $categories,
                'recherches' => $recherches
            )
        );
    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Categorie $categorie)
    {
        if(count($categorie->getEvenements()) != 0)  throw new NotFoundHttpException('Cette page n\'est pas disponible');

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Catégorie supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_evenementcategorie_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Categorie $categorie)
    {
        $form = $this->createForm(CategorieType::class, $categorie);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Catégorie enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_evenementcategorie_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des catégories' => $this->generateUrl('admin_evenementcategorie_manager'),
            'Modifier une catégorie' => ''
        );

        return $this->render('Evenement/Admin/Categorie/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'categorie' => $categorie,
                'form' => $form->createView()
            )
        );

    }

}
