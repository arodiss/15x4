<?php

namespace AdminBundle\Controller;

use AppBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractAdminController extends AbstractController
{
    const ITEMS_PER_PAGE = 20;

    /** @return array */
    abstract protected function getAdminConfig();

    /**
     * @param Request $request
     * @param null $queryBuilder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function manageList(Request $request, $queryBuilder = null, $additionalData = [])
    {
        $queryBuilder = $queryBuilder ?: $this->get($this->getAdminConfig()['repository_service'])->getAdminQb();
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
                    array_merge(
                        [
                            'is_list_view' => false,
                            'pagination' => $this->getPager()->paginate(
                                $queryBuilder,
                                $request->get('page', 1),
                                self::ITEMS_PER_PAGE
                            ),
                            'form' => $form->createView()
                        ],
                        $this->getAdditionalListData(),
                        $additionalData
                    )
                );
            }
        }

        return $this->render(
            $this->getAdminConfig()['list_template'],
            array_merge(
                [
                    'is_list_view' => (bool) $request->get('page'),
                    'pagination' => $this->getPager()->paginate(
                        $queryBuilder,
                        $request->get('page', 1),
                        self::ITEMS_PER_PAGE
                    ),
                    'form' => $this->createForm($this->getAdminConfig()['form_type'])->createView()
                ],
                $this->getAdditionalListData(),
                $additionalData
            )
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

    /** @return array */
    protected function getAdditionalListData()
    {
        return [];
    }
} 
