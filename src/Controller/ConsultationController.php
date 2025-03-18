<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Consultation;
use App\Form\ConsultationFormType;
use App\Form\ConsultationSearchFormType;
use App\Repository\ConsultationRepository;
use App\Repository\TopicRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/{_locale}')]
class ConsultationController extends BaseController
{

    public function __construct(
        private readonly ConsultationRepository $repo, 
        private readonly TopicRepository $topicRepo, 
        private readonly EntityManagerInterface $em
        )
    {
    }

    #[Route(path: '/consultation/new', name: 'consultation_new')]
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(ConsultationFormType::class, new Consultation(), [
            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Consultation $data */
            $data = $form->getData();
            if (empty($data->getTopic())) {
                return $this->render('consultation/edit.html.twig', [
                    'form' => $form,
                    'saveButton' => true,
                    'new' => true, 
                ]);
            }
            $data->setEndDate(new DateTime());
            $data->setAttendedBy($this->getUser());
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'consultation.saved');
            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/edit.html.twig', [
            'form' => $form,
            'saveButton' => true,
            'new' => true, 
        ]);
    }

    #[Route(path: '/consultation/{id}/edit', name: 'consultation_edit')]
    public function edit(Request $request, #[MapEntity] Consultation $consultation): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(ConsultationFormType::class, $consultation, [
            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Consultation $data */
            $data = $form->getData();
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'consultation.saved');
            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/edit.html.twig', [
            'form' => $form,
            'saveButton' => true,
            'new' => false, 
        ]);
    }

    #[Route(path: '/consultation/{id}', name: 'consultation_show')]
    public function show(Request $request, #[MapEntity] Consultation $consultation): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(ConsultationFormType::class, $consultation, [
            'locale' => $request->getLocale(),
        ]);

        return $this->render('consultation/edit.html.twig', [
            'form' => $form,
            'saveButton' => false,
            'new' => false, 
        ]);
    }

    #[Route(path: '/consultaion/{id}/delete', name: 'consultation_delete', options: ['expose' => true])]
    public function delete(Request $request, #[MapEntity] Consultation $consultation): Response
    {
        $this->loadQueryParameters($request);
        $this->em->remove($consultation);
        $this->em->flush();
        $this->addFlash('success', 'consultation.deleted');
        return $this->redirectToRoute('consultation_index', $request->query->all());
    }

    #[Route(path: '/consultation', name: 'consultation_index', options: ['expose' => true])]
    public function list(Request $request, TranslatorInterface $translator): Response
    {
        $this->loadQueryParameters($request);
        $maxResults = $this->getParameter('maxResults');
        $consultation = $this->createConsultation($request);
        $form = $this->createForm(ConsultationSearchFormType::class, $consultation, [
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Consultation $filter */
            $filter = $form->getData();
            $consultations = $this->repo->findByConsultationFilter($filter);
            $consultations = array_slice($consultations, 0, $maxResults);
            if ($maxResults === count($consultations)) {
                $this->addFlash(
                    'warning',
                    $translator->trans(
                        'maxResults.reached',
                        [
                            '%maxResults%' => $maxResults,
                        ]
                    )
                );
            }
            return $this->render('consultation/index.html.twig', [
                'consultations' => $consultations,
                'form' => $form,
                'filters' => $filter->filterToArray(),
            ]);
        }
        $consultations = $this->repo->findByConsultationFilter($consultation, $maxResults);

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
            'form' => $form,
            'filters' => $consultation->filterToArray(),
        ]);
    }

    private function createConsultation(Request $request) {
        $consultation = new Consultation();
        if ( $request->get('startDate') && !empty($request->get('startDate')) ) {
            $consultation->setStartDate(new DateTime($request->get('startDate')));  
        } else {
            $todayStr = (new DateTime())->format('Y-m-d');
            $today = new DateTime($todayStr);
            $consultation->setStartDate($today);
        }
        if ( $request->get('endDate') && !empty($request->get('endDate')) ) {
            $consultation->setEndDate(new DateTime($request->get('endDate')));
        } else {
            $now = new DateTime();
            $consultation->setEndDate($now->modify('+1 minute'));
        }
        if ( $request->get('topic') && !empty($request->get('topic')) ) {
            $topics = explode(',', (string) $request->get('topic'));
            $topicsArray = $this->topicRepo->findTopics($topics);
            foreach ( $topicsArray as $topic ) {
                $consultation->addTopic($topic);
            }
        }
        return $consultation;
    }
}
