<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Topic;
use App\Form\TopicFormType;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/{_locale}')]
class TopicController extends BaseController
{
    public function __construct(private readonly TopicRepository $repo, private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: '/topic/new', name: 'topic_new', options: ['expose' => true])]
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(TopicFormType::class, new Topic());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Topic $topic */
            $topic = $form->getData();
            $this->em->persist($topic);
            $this->em->flush();
            $this->addFlash('success', 'topic.saved');
            return $this->redirectToRoute('topic_index');
        }

        return $this->render('topic/edit.html.twig', [
            'form' => $form,
            'saveButton' => true,
        ]);
    }

    #[Route(path: '/topic/{id}', name: 'topic_show', options: ['expose' => true])]
    public function show(Request $request, #[MapEntity] Topic $topic): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(TopicFormType::class, $topic);

        $form->handleRequest($request);

        return $this->render('topic/edit.html.twig', [
            'form' => $form,
            'saveButton' => false,
        ]);
    }

    #[Route(path: '/topic/{id}/edit', name: 'topic_edit', options: ['expose' => true])]
    public function edit(Request $request, #[MapEntity] Topic $topic): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(TopicFormType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Topic $topic */
            $topic = $form->getData();
            $this->em->persist($topic);
            $this->em->flush();
            $this->addFlash('success', 'topic.saved');
            return $this->redirectToRoute('topic_index');
        }

        return $this->render('topic/edit.html.twig', [
            'form' => $form,
            'saveButton' => true,
        ]);
    }

    #[Route(path: '/topic/{id}/delete', name: 'topic_delete', options: ['expose' => true])]
    public function delete(Request $request, #[MapEntity] Topic $topic): Response
    {
        $this->loadQueryParameters($request);
        if (count($topic->getConsultations()) > 0) {
            $this->addFlash('error', 'topic.notDeleted');
        } else {
            $this->em->remove($topic);
            $this->em->flush();
            $this->addFlash('success', 'topic.deleted');
        }
        return $this->redirectToRoute('topic_index');
    }

    #[Route(path: '/topic', name: 'topic_index', options: ['expose' => true])]
    public function list(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $topics = $this->repo->findAll();
        return $this->render('topic/index.html.twig', [
            'topics' => $topics,
        ]);
    }
}
