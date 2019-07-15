<?php

namespace App\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\Contact\ContactType;
use App\Entity\Contact\Contact;
use App\Entity\Contact\Objet;
use App\Utilities\Recherche;
use App\Entity\General\Langue;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterClient(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator)
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact, array('langue' => $request->getLocale()));

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            /* Notification */
            $emails = explode(';',$contact->getObjet()->getEmail());

            $message = (new \Swift_Message($translator->trans('Formulaire de contact')))
                ->setFrom('contact@colocarts.com')
                ->setTo($emails)
                ->setBody(
                    $this->renderView('General/Mail/simple.html.twig', array(
                            'titre' => 'Formulaire de contact',
                            'contenu' => '<strong>Nom: </strong>'.$contact->getNom().'<br><strong>Prénom: </strong>'.$contact->getPrenom().'<br><strong>Email: </strong>'.$contact->getEmail().'<br><strong>Objet: </strong>'.$contact->getObjet()->getNom().'<br><strong>Message: </strong><br>'.$contact->getMessage()
                        )
                    ),
                    'text/html'
                );

            /* Envoyer le message */
            $mailer->send($message);

            $request->getSession()->getFlashBag()->add('succes', $translator->trans('contact.client.validators.succes'));
            return $this->redirect($this->generateUrl('client_page_index'));
        }

        return $this->render( 'Contact/ajouter.html.twig',
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
        $recherches = $recherche->setRecherche('conact_manager', array(
                'objet',
                'langue'
            )
        );

        /* La liste des objets */
        $objets = $this->getDoctrine()
                       ->getRepository(Objet::class)
                       ->findBy(array(),array('id' => 'DESC'));

        /* La liste des contact */
        $contacts = $this->getDoctrine()
                         ->getRepository(Contact::class)
                         ->getAllContacts($recherches['objet'], $recherches['langue']);

        $pagination = $paginator->paginate(
            $contacts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Contact/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'objets' => $objets,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /*
     * View
     */
    public function viewAdmin(Contact $contact)
    {
        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des contacts' => $this->generateUrl('admin_contact_manager'),
            'Afficher un contact' => ''
        );

        return $this->render( 'Contact/Admin/view.html.twig',array(
                'contact' => $contact,
                'breadcrumb' => $breadcrumb
            )
        );
    }
}
