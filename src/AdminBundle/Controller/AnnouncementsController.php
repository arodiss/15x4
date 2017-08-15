<?php

namespace AdminBundle\Controller;

use AppBundle\IFTTT\IftttHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form\AnnouncementType;
use AdminBundle\Form\EventFromAnnouncementType;
use AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementsController extends Controller
{
    /**
     * @Extra\Route("/announcements/", name="AdminAnnouncements")
     * @Extra\Template("admin/announcements.html.twig")
     */
    public function indexAction()
    {
        return ['cities' => $this->get('repository.city')->findForAnnouncementList()];
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
                if (false === $this->get('kernel')->isDebug()) {
                    IftttHandler::handleAnnouncement($form->getData());
                }

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

    /**
     * @Extra\Route("/announcements/{id}/get-tickets", name="GetAnnouncementTickets")
     * @Extra\ParamConverter
     */
    public function downloadTicketsAction(Entity\Announcement $announcement)
    {
        $file = $this
            ->get("arodiss.xls.builder")
            ->buildXlsFromArray(array_merge(
                [['Имя', 'Количество мест']],
                $announcement->getTicketsBookedGrouped()
            ))
        ;

        $response = new Response();
        $response->headers->set("Content-Type", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        $response->headers->set("Content-Disposition", "attachment;filename=tickets.xlsx");
        $response->setContent(file_get_contents($file));

        return $response;
    }

    /**
     * @Extra\Route("/announcements/{id}/get-volunteers", name="GetAnnouncementVolunteers")
     * @Extra\ParamConverter
     */
    public function downloadVolunteersAction(Entity\Announcement $announcement)
    {
        $file = $this
            ->get("arodiss.xls.builder")
            ->buildXlsFromArray(array_merge(
                [['Имя', 'Контакты']],
                $announcement->getVolunteers()
            ))
        ;

        $response = new Response();
        $response->headers->set("Content-Type", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        $response->headers->set("Content-Disposition", "attachment;filename=volunteers.xlsx");
        $response->setContent(file_get_contents($file));

        return $response;
    }
}
