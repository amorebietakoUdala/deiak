<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use App\Entity\Topic;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ConsultationFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'consultations', function ($i) use ($manager) {
            $consultation = new Consultation();
            $consultation->setStartDate($this->faker->dateTimeBetween('now', '+5 minutes'));
            $consultation->setEndDate($this->faker->dateTimeBetween('+5 minutes', '+10 minutes'));
            $consultation->addTopic($this->getRandomReference('topics'));
            $consultation->setAttendedBy($this->getRandomReference('main_users'));

            return $consultation;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TopicFixtures::class,
            UserFixtures::class
        ];
    }
}
