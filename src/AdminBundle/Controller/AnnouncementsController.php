<?php

namespace AdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form\AnnouncementType;
use AdminBundle\Form\EventFromAnnouncementType;
use AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementsController extends Controller
{
    /**
     * @Extra\Route("/announcements/", name="AdminAnnouncements")
     * @Extra\Template("admin/announcements.html.twig")
     */
    public function indexAction()
    {
        return ['cities' => $this->get('repository.city')->findAll()];
    }

    /**
     * @Extra\Route("/announcements/city-{id}/add", name="AddAnnouncement")
     * @Extra\Template("admin/add-announcement.html.twig")
     * @Extra\ParamConverter
     */
    public function addAction(Request $request, Entity\City $city)
    {
        if ($request->isMethod('POST')) {
            $form = $this->createForm(AnnouncementType::class)->handleRequest($request);
            if ($form->isValid()) {
                $this->get("doctrine.orm.entity_manager")->persist($form->getData());
                $this->get("doctrine.orm.entity_manager")->flush();

                $this->addFlash('success', 'Анонс сохранён');
            } else {
                $this->addFlash('error', 'Не удалось сохранить анонс');
            }

            return $this->redirectToRoute('AdminAnnouncements');
        }

        return [
            'form' => $this
                ->createForm(
                    AnnouncementType::class,
                    (new Entity\Announcement())->setCity($city)
                )
                ->createView()
        ];
    }

    /**
     * @Extra\Route("/announcements/{id}/implement", name="EventFromAnnouncement")
     * @Extra\Template("admin/raw-form.html.twig")
     * @Extra\ParamConverter
     */
    public function eventFromAnnouncementAction(Request $request, Entity\Announcement $announcement)
    {
        $event = Entity\Event::fromAnnouncement($announcement);
        $this->get("doctrine.orm.entity_manager")->persist($event);
        $form = $this->createForm(EventFromAnnouncementType::class, $event);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->get("doctrine.orm.entity_manager")->persist($form->getData());
                $this->get("doctrine.orm.entity_manager")->remove($announcement);
                $this->get("doctrine.orm.entity_manager")->flush();
                $this->addFlash('success', 'Встреча создана');
            } else {
                $this->addFlash('error', 'Не удалось создать встречу');
            }

            return $this->redirectToRoute('AdminAnnouncements');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Extra\Route("/announcements/{id}/edit", name="AdminAnnouncementEdit")
     * @Extra\ParamConverter
     */
    public function editAction(Request $request, Entity\Announcement $announcement)
    {
        $form = $this->createForm(AnnouncementType::class, $announcement)->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $this->get('doctrine.orm.entity_manager')->persist($form->getData());
                $this->get('doctrine.orm.entity_manager')->flush();
                $this->addFlash('success', 'Изменения сохранены');
            } else {
                dump($form->getErrors());
                $this->addFlash('error', 'Не удалось сохранить изменения');
            }

            return $this->redirectToRoute('AdminAnnouncements');
        }

        return $this->render("admin/edit-announcement.html.twig", [ 'form' => $form->createView() ]);
    }

    /**
     * @Extra\Route("/announcements/{id}/delete", name="AdminAnnouncementDelete")
     * @Extra\ParamConverter
     */
    public function deleteAction(Entity\Announcement $announcement)
    {
        $this->get('doctrine.orm.entity_manager')->remove($announcement);
        $this->get('doctrine.orm.entity_manager')->flush();
        $this->addFlash('success', 'Удалено');

        return $this->redirectToRoute('AdminAnnouncements');
    }
}
