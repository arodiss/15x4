<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\City;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class CitiesAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/cities/", name="AdminCities")
     */
    public function citiesAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/cities/{id}/edit", name="AdminCityEdit")
     */
    public function editEventAction(Request $request, City $city)
    {
        return $this->manageEdit($request, $city);
    }

    /**
     * @Extra\Route("/cities/{id}/delete", name="AdminCityDelete")
     */
    public function deleteEventAction(City $city)
    {
        return $this->manageDelete($city);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminCities',
            'list_template' => 'admin/cities.html.twig',
            'repository_service' => 'repository.city',
            'form_type' => Form\CityType::class,
        ];
    }
} 
