<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class TagsAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/tags/", name="AdminTags")
     */
    public function tagsAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/tags/{id}/edit", name="AdminTagEdit")
     */
    public function editTagAction(Request $request, Tag $tag)
    {
        return $this->manageEdit($request, $tag);
    }

    /**
     * @Extra\Route("/tags/{id}/delete", name="AdminTagDelete")
     */
    public function deleteTagAction(Tag $tag)
    {
        return $this->manageDelete($tag);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminTags',
            'list_template' => 'admin/tags.html.twig',
            'repository_service' => 'repository.tag',
            'form_type' => Form\TagType::class,
        ];
    }
} 
