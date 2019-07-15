<?php

namespace App\Controller\Slider;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Slider\SliderType;
use App\Entity\Slider\Slider;
use App\Entity\Slider\Slide;
use App\Utilities\Recherche;
use App\Entity\General\Langue;

class SliderController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $slider = new Slider;
        $form = $this->createForm(SliderType::class, $slider);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Slider enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_slider_manager'));
        }

        return $this->render('Slider/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {
        /* Services */
        $recherches = $recherche->setRecherche('slider_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des sliders */
        $sliders = $this->getDoctrine()
                        ->getRepository(Slider::class)
                        ->getAllSliders($recherches['recherche'], $recherches['langue']);

        $pagination = $paginator->paginate(
            $sliders, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render( 'Slider/Admin/manager.html.twig', array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Slider $slider)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($slider);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Slider supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_slider_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Slider $slider)
    {
        $form = $this->createForm(SliderType::class, $slider);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Slider enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_slider_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des sliders' => $this->generateUrl('admin_slider_manager'),
            'Modifier un slider' => ''
        );

        return $this->render('Slider/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'slider' => $slider,
                'form' => $form->createView()
            )
        );

    }

    /**
     * View
     */
    public function viewClient(Slider $slider)
    {
        /* La liste des slides */
        $slides = $this->getDoctrine()
                       ->getRepository(Slide::class)
                       ->findBy(array('slider' => $slider, 'isActive' => true),array('poid' => 'DESC'));

        return $this->render('Slider/Include/view.html.twig',
            array(
                'slides' => $slides
            )
        );
    }

}
