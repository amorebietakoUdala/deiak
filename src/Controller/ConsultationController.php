<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationFormType;
use App\Form\ConsultationSearchFormType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/consultation/new", name="consultation_new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(ConsultationFormType::class, new Consultation(), [
            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Consultation $data */
            $data = $form->getData();
            $data->setEndDate(new DateTime());
            $data->setAttendedBy($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'consultation.saved');
            return $this->redirectToRoute('consultation_list');
        }
        return $this->render('consultation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/consultation/{id}/edit", name="consultation_edit")
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(ConsultationFormType::class, $consultation, [
            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Consultation $data */
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'consultation.saved');
            return $this->redirectToRoute('consultation_list');
        }

        return $this->render('consultation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/consultation/{id}", name="consultation_show")
     */
    public function show(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(ConsultationFormType::class, $consultation, [
            'locale' => $request->getLocale(),
        ]);

        return $this->render('consultation/show.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/consultaion/{id}/delete", name="consultation_delete", options={"expose"=true})
     */
    public function delete(Request $request, Consultation $consultation): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultation);
        $em->flush();
        $this->addFlash('success', 'consultation.deleted');
        return $this->redirectToRoute('consultation_list');
    }

    /**
     * @Route("/consultation", name="consultation_list", options={"expose"=true})
     */
    public function list(Request $request): Response
    {
        $maxResults = $this->getParameter('maxResults');
        $form = $this->createForm(ConsultationSearchFormType::class, $consultation = new Consultation(), [
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $consultation = $form->getData();
            $consultations = $this->getDoctrine()->getManager()->getRepository(Consultation::class)->findByConsultationFilter($consultation, $maxResults);
            //            dd($consultations);
            return $this->render('consultation/list.html.twig', [
                'consultations' => $consultations,
                'form' => $form->createView(),
            ]);
        }
        $todayStr = (new DateTime())->format('Y-m-d');
        $today = new DateTime($todayStr);
        $now = new DateTime();
        $consultation->setStartDate($today);
        $consultation->setEndDate($now);
        $form->setData($consultation);
        $consultations = $this->getDoctrine()->getManager()->getRepository(Consultation::class)->findByConsultationFilter($consultation, $maxResults);

        return $this->render('consultation/list.html.twig', [
            'consultations' => $consultations,
            'form' => $form->createView(),
        ]);
    }
}
