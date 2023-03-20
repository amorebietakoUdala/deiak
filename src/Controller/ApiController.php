<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @IsGranted("ROLE_DEIAK")
 */
class ApiController extends AbstractController
{
    private $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/api/{id}/topics", name="api_get_consultation_topics", options={"expose"=true})
     */
    public function getConsultationTopics(Request $request, Consultation $consultation): Response
    {
        $topics = $consultation->getTopic()->toArray();
        $jsonContent = $this->serializer->normalize($topics, 'json', [
            // This works too but the second one looks better
            // AbstractNormalizer::ATTRIBUTES => ['id', 'descriptionEs',  'descriptionEu']
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['consultations']
        ]);
        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/api/consultation/{id}/topic/{topic}/remove", name="api_remove_consultation_topic", options={"expose"=true})
     */
    public function removeConsultationTopic(Request $request, Consultation $consultation, Topic $topic): Response
    {
        $consultation->removeTopic($topic);
        $em = $this->getDoctrine()->getManager();
        $em->persist($consultation);
        $em->flush();
        return new JsonResponse('OK');
    }
}
