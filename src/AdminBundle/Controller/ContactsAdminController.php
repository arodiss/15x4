<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\Contact;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class ContactsAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/contacts/", name="AdminContacts")
     */
    public function contactsAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/contacts/{id}/edit", name="AdminContactEdit")
     */
    public function editContactAction(Request $request, Contact $contact)
    {
        return $this->manageEdit($request, $contact);
    }

    /**
     * @Extra\Route("/contacts/{id}/delete", name="AdminContactDelete")
     */
    public function deleteContactAction(Contact $contact)
    {
        return $this->manageDelete($contact);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminContacts',
            'list_template' => 'admin/contacts.html.twig',
            'repository_service' => 'repository.contact',
            'form_type' => Form\ContactType::class,
        ];
    }
} 
