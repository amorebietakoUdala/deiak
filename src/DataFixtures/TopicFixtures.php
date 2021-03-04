<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TopicFixtures extends BaseFixture
{
    private $topics;

    protected function loadData(ObjectManager $manager)
    {
        // $this->topics = [
        //     'Ekonomia' => 'Economía',
        //     'Errolda altak/Aldaketak/Agiriak' => 'Padrón altas/modoficaciones/volantes',
        //     'Gizarte ekintza/Hezkuntza' => 'Acción social/Educación',
        //     'Zerbitzuak' => 'Servicios',
        //     'Kultura/Kirola' => 'Cultura/Deportes',
        //     'Hirigintza' => 'Urbanismo',
        //     'Lan/Ekonomi sustapena' => 'Empleo y promoción económica',
        //     'Idazkaritza' => 'Secretaría',
        //     'Alkatetza' => 'Alcaldía',
        //     'Udaltzaingoa' => 'Udaltzaingoa',
        //     'Beste batzu' => 'Otros',
        //     'Euskera-Euskaltegia' => 'Euskera-Euskaltegi'
        // ];

        // foreach ($this->topics as $key => $value) {
        //     $topic = $this->createTopic($key, $value);
        //     $manager->persist($topic);
        // }

        $this->createMany(10, 'topics', function ($i) {
            $topic = new Topic();
            $topic->setDescriptionEs(sprintf('topic-es-%d', $i));
            $topic->setDescriptionEu(sprintf('topic-eu-%d', $i));
            return $topic;
        });

        $manager->flush();
    }

    private function createTopic($descriptionEu, $descriptionEs)
    {
        $topic = new Topic();
        $topic->setDescriptionEs($descriptionEs);
        $topic->setDescriptionEu($descriptionEu);
        return $topic;
    }
}
