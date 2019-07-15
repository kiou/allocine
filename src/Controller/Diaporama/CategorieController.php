<?php

namespace App\Controller\Diaporama;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Form\Diaporama\CategorieType;
use App\Entity\Diaporama\Categorie;
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
            return $this->redirect($this->generateUrl('admin_diaporama_categorie_manager'));
        }

        return $this->render('Diaporama/Admin/Categorie/ajouter.html.twig',
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
        $recherches = $recherche->setRecherche('diaporamacategorie_manager', array(
                'langue'
            )
        );

        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAllCategories($recherches['langue']);

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Diaporama/Admin/Categorie/manager.html.twig',array(
                'categories' => $categories,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Categorie $categorie)
    {
        if(count($categorie->getGaleries()) != 0)  throw new NotFoundHttpException('Cette page n\'est pas disponible');

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Catégorie supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_diaporama_categorie_manager'));
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
            return $this->redirect($this->generateUrl('admin_diaporama_categorie_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des catégories' => $this->generateUrl('admin_diaporama_categorie_manager'),
            'Modifier une catégorie' => ''
        );

        return $this->render('Diaporama/Admin/Categorie/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'categorie' => $categorie,
                'form' => $form->createView()
            )
        );

    }

}
