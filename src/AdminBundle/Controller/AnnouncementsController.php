<?php

namespace AdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form\AnnouncementType;
use AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementsController extends Controller
{
    /**
     * @Extra\Route("/announcements/", name="AdminAnnouncements")
     * @Extra\Template("admin/announcements.html.twig")
     */
    public function indexAction(Request $request)
    {
        $cities = [];
        foreach ($this->get('repository.city')->findAll() as $cityRaw) {
            /** @var Entity\City $cityRaw */
            $cities[] = [
                'city' => $cityRaw,
                'form' => $this->createForm(
                    AnnouncementType::class,
                    $this->getCityAnnouncement($cityRaw)
                )->createView(),
            ];
        }
        if ($request->isMethod('POST')) {
            $announcement = $this->getCityAnnouncement(
                $this->get('repository.city')->find($request->get('announcement')['city'])
            );
            $originalLectures = new ArrayCollection();
            foreach ($announcement->getLectures() as $lectures) {
                $originalLectures->add($lectures);
            }
            $form = $this->createForm(AnnouncementType::class, $announcement)->handleRequest($request);
            if ($form->isValid()) {
                foreach ($originalLectures as $lecture) {
                    if (false === $announcement->getLectures()->contains($lecture)) {
                        $this->get("doctrine.orm.entity_manager")->remove($lecture);
                    }
                }

                $this->get("doctrine.orm.entity_manager")->persist($form->getData());
                $this->get("doctrine.orm.entity_manager")->flush();
                $this->addFlash('success', 'Анонс сохранён');
            } else {
                $this->addFlash('error', 'Не удалось сохранить анонс');
            }

            return $this->redirectToRoute('AdminAnnouncements');
        }

        return ['cities' => $cities];
    }

    /**
     * @param Entity\City $city
     * @return Entity\Announcement
     */
    private function getCityAnnouncement(Entity\City $city)
    {
        return $city->getAnnouncement() ?: (new Entity\Announcement())->setCity($city);
    }
}
