<?php

namespace App\Controller\General;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\General\Langue;

class GeneralController extends Controller{

    /**
     * L'index du site
     */
    public function ClientIndex()
    {
        return $this->render('General/Page/index.html.twig');
    }

    /**
     * L'index de l'administration
     */
    public function AdminIndex()
    {
        return $this->render('General/Admin/Page/index.html.twig');
    }

    /**
     * Selecteur de langue
     */
    public function SelecteurLangue()
    {
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('General/Langue/selecteur.html.twig',array(
                'langues' => $langues
            )
        );
    }

}

?>