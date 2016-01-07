<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\Lecturer;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class LecturersAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/lecturers/", name="AdminLecturers")
     */
    public function lecturersAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/lecturers/{id}/edit", name="AdminLecturerEdit")
     */
    public function editEventAction(Request $request, Lecturer $lecturer)
    {
        return $this->manageEdit($request, $lecturer);
    }

    /**
     * @Extra\Route("/lecturers/{id}/delete", name="AdminLecturerDelete")
     */
    public function deleteEventAction(Lecturer $lecturer)
    {
        return $this->manageDelete($lecturer);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminLecturers',
            'list_template' => 'admin/lecturers.html.twig',
            'repository_service' => 'repository.lecturer',
            'form_type' => Form\LecturerType::class,
        ];
    }
} 
