<?php

namespace App\Controller\Slider;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\Slider\SlideType;
use App\Entity\Slider\Slide;
use App\Entity\Slider\Slider;

class SlideController extends Controller
{

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request, Slider $slider)
    {
        $slide = new Slide;
        $form = $this->createForm(SlideType::class, $slide);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slide->uploadImage();
            $slide->setSlider($slider);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Slide enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_sliderslide_manager',array('slider' => $slider->getId())));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des sliders' => $this->generateUrl('admin_slider_manager'),
            'Gestion des slides' => $this->generateUrl('admin_sliderslide_manager', array('slider' => $slider->getId())),
            'Ajouter un slide' => ''
        );

        return $this->render('Slider/Admin/Slide/ajouter.html.twig',
            array(
                'form' => $form->createView(),
                'slider' => $slider,
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Request $request, Slider $slider)
    {
        /* La liste des slides */
        $slides = $this->getDoctrine()
                       ->getRepository(Slide::class)
                       ->findBy(array('slider' => $slider),array('id' => 'DESC'));

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des sliders' => $this->generateUrl('admin_slider_manager'),
            'Gestion des slides' => ''
        );

        return $this->render( 'Slider/Admin/Slide/manager.html.twig', array(
                'slides' => $slides,
                'slider' => $slider,
                'breadcrumb' => $breadcrumb
            )
        );

    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Slider $slider, Slide $slide){

        if($request->isXmlHttpRequest()){
            $state = $slide->reverseState();
            $slide->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Slider $slider, Slide $slide)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($slide);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Slide supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_sliderslide_manager', array('slider' => $slider->getId())));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Slider $slider, Slide $slide)
    {
        $form = $this->createForm(SlideType::class, $slide);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slide->uploadImage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Slide enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_sliderslide_manager',array('slider' => $slider->getId())));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des sliders' => $this->generateUrl('admin_slider_manager'),
            'Gestion des slides' => $this->generateUrl('admin_sliderslide_manager',array('slider' => $slider->getId())),
            'Modifier un slide' => ''
        );

        return $this->render('Slider/Admin/Slide/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'slider' => $slider,
                'slide' => $slide,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Poid
     */
    public function poidAdmin(Request $request, Slider $slider, Slide $slide, $poid){

        if($request->isXmlHttpRequest()){
            $slide->setPoid($poid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            return new JsonResponse(array('status' => 'succes'));
        }

    }

}
