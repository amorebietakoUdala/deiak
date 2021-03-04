<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/topic/new", name="topic_new", options={"expose"=true})
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(TopicFormType::class, new Topic());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Topic $topic */
            $topic = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();
            $this->addFlash('success', 'topic.saved');
            return $this->redirectToRoute('topic_list');
        }

        return $this->render('topic/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/topic/{id}", name="topic_show", options={"expose"=true})
     */
    public function show(Request $request, Topic $topic): Response
    {

        $form = $this->createForm(TopicFormType::class, $topic);

        $form->handleRequest($request);

        return $this->render('topic/show.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/topic/{id}/edit", name="topic_edit", options={"expose"=true})
     */
    public function edit(Request $request, Topic $topic): Response
    {
        $form = $this->createForm(TopicFormType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Topic $topic */
            $topic = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();
            $this->addFlash('success', 'topic.saved');
            return $this->redirectToRoute('topic_list');
        }

        return $this->render('topic/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/topic/{id}/delete", name="topic_delete", options={"expose"=true})
     */
    public function delete(Request $request, Topic $topic): Response
    {
        if (count($topic->getConsultations()) > 0) {
            $this->addFlash('error', 'topic.notDeleted');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
            $this->addFlash('success', 'topic.deleted');
        }
        return $this->redirectToRoute('topic_list');
    }

    /**
     * @Route("/topic", name="topic_list", options={"expose"=true})
     */
    public function list(): Response
    {
        $topics = $this->getDoctrine()->getManager()->getRepository(Topic::class)->findAll();
        return $this->render('topic/list.html.twig', [
            'topics' => $topics,
        ]);
    }
}
