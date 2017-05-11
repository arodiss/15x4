<?php

namespace AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractAdminController extends Controller
{
    const ITEMS_PER_PAGE = 20;

    /** @return array */
    abstract protected function getAdminConfig();

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function manageList(Request $request)
    {
        if ($request->isMethod('POST')) {
            $form = $this->createForm($this->getAdminConfig()['form_type'])->handleRequest($request);
            if ($form->isValid()) {
                $this->getEm()->persist($form->getData());
                $this->getEm()->flush();
                $this->addFlash('success', 'Создано успешно');

                return $this->redirectToRoute($this->getAdminConfig()['list_route']);
            } else {
                $this->addFlash('error', 'Создать не удалось');

                return $this->render(
                    $this->getAdminConfig()['list_template'],
                    [
                        'is_list_view' => false,
                        'pagination' => $this->getPager()->paginate(
                            $this->get($this->getAdminConfig()['repository_service'])->getAdminQb(),
                            $request->get('page', 1),
                            self::ITEMS_PER_PAGE
                        ),
                        'form' => $form->createView()
                    ]
                );
            }
        }

        return $this->render(
            $this->getAdminConfig()['list_template'],
            [
                'is_list_view' => (bool) $request->get('page'),
                'pagination' => $this->getPager()->paginate(
                    $this->get($this->getAdminConfig()['repository_service'])->getAdminQb(),
                    $request->get('page', 1),
                    self::ITEMS_PER_PAGE
                ),
                'form' => $this->createForm($this->getAdminConfig()['form_type'])->createView()
            ]
        );
    }

    /**
     * @param Request $request
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function manageEdit(Request $request, $entity)
    {
        $form = $this->createForm($this->getAdminConfig()['form_type'], $entity)->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $this->getEm()->persist($form->getData());
                $this->getEm()->flush();
                $this->addFlash('success', 'Изменения сохранены');
            } else {
                $this->addFlash('error', 'Не удалось сохранить изменения');
            }

            return $this->redirectToRoute($this->getAdminConfig()['list_route']);
        }

        return $this->render("admin/raw-form.html.twig", [ 'form' => $form->createView() ]);
    }

    /**
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function manageDelete($entity)
    {
        $this->getEm()->remove($entity);
        $this->getEm()->flush();
        $this->addFlash('success', 'Удалено');

        return $this->redirectToRoute($this->getAdminConfig()['list_route']);
    }

    /** @return EntityManager */
    protected function getEm()
    {
        return $this->get("doctrine.orm.entity_manager");
    }

    /** @return \Knp\Component\Pager\Paginator */
    protected function getPager()
    {
        return $this->get('knp_paginator');
    }
} 
