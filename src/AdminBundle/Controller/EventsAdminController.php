<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\Event;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class EventsAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/events/", name="AdminEvents")
     */
    public function eventsAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/events/{id}/edit", name="AdminEventEdit")
     */
    public function editEventAction(Request $request, Event $event)
    {
        return $this->manageEdit($request, $event);
    }

    /**
     * @Extra\Route("/events/{id}/delete", name="AdminEventDelete")
     */
    public function deleteEventAction(Event $event)
    {
        return $this->manageDelete($event);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminEvents',
            'list_template' => 'admin/events.html.twig',
            'repository_service' => 'repository.event',
            'form_type' => Form\EventType::class,
        ];
    }
} 
