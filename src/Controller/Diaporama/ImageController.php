<?php

namespace App\Controller\Diaporama;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\Diaporama\ImageType;
use App\Entity\Diaporama\Image;
use App\Entity\Diaporama\Galerie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends Controller
{

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request, Galerie $galerie)
    {
        $image = new Image;
        $form = $this->createForm(ImageType::class, $image);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image->uploadImage();
            $image->setGalerie($galerie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Image enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_diaporama_image_manager',array('galerie' => $galerie->getId())));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des galeries' => $this->generateUrl('admin_diaporama_manager'),
            'Gestion des images' => $this->generateUrl('admin_diaporama_image_manager', array('galerie' => $galerie->getId())),
            'Ajouter une image' => ''
        );

        return $this->render('Diaporama/Admin/Image/ajouter.html.twig',
            array(
                'form' => $form->createView(),
                'galerie' => $galerie,
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Galerie $galerie)
    {
        /* La liste des images */
        $images = $this->getDoctrine()
                       ->getRepository(Image::class)
                       ->findBy(array('galerie' => $galerie),array('id' => 'DESC'));

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des galeries' => $this->generateUrl('admin_diaporama_manager'),
            'Gestion des images' => ''
        );

        return $this->render( 'Diaporama/Admin/Image/manager.html.twig', array(
                'images' => $images,
                'galerie' => $galerie,
                'breadcrumb' => $breadcrumb
            )
        );

    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Galerie $galerie, Image $image)
    {
        $form = $this->get('form.factory')->create(ImageType::class, $image);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image->uploadImage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Image enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_diaporama_image_manager',array('galerie' => $galerie->getId())));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des galeries' => $this->generateUrl('admin_diaporama_manager'),
            'Gestion des images' => $this->generateUrl('admin_diaporama_image_manager', array('galerie' => $galerie->getId())),
            'Modifier une image' => ''
        );

        return $this->render('Diaporama/Admin/Image/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'galerie' => $galerie,
                'image' => $image,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Galerie $galerie, Image $image){

        if($request->isXmlHttpRequest()){
            $state = $image->reverseState();
            $image->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Galerie $galerie, Image $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Image supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_diaporama_image_manager', array('galerie' => $galerie->getId())));
    }

    /**
     * Poid
     */
    public function poidAdmin(Request $request, Galerie $galerie, Image $image, $poid){

        if($request->isXmlHttpRequest()){
            $image->setPoid($poid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return new JsonResponse(array('status' => 'succes'));
        }

    }

}
