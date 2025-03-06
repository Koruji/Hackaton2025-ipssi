<?php

namespace App\Tests\Entity;

use App\Entity\Chantier;
use App\Entity\Competence;
use App\Entity\Mission;
use PHPUnit\Framework\TestCase;

class ChantierTest extends TestCase
{
   public function testSetAndGetNom() {
       $chantier = new Chantier();
       $chantier->setNom("Construction immeubles");
       $this->assertEquals("Construction immeubles", $chantier->getNom());
   }

   public function testSetAndGetAdresse() {
       $chantier = new Chantier();
       $chantier->setAdresse("Rue de la liberté");
       $this->assertEquals("Rue de la liberté", $chantier->getAdresse());
   }

   public function testSetAndGetDateDebutTravaux() {
       $chantier = new Chantier();
       $date = new \DateTime('2024-01-01');
       $chantier->setDebutTravaux($date);
       $this->assertEquals($date, $chantier->getDebutTravaux());
   }

   public function testSetAndGetDateFinTravaux() {
       $chantier = new Chantier();
       $date = new \DateTime('2024-02-01');
       $chantier->setFinTravaux($date);
       $this->assertEquals($date, $chantier->getFinTravaux());
   }

   public function testSetAndGetStatut() {
       $chantier = new Chantier();
       $chantier->setStatus('En cours');
       $this->assertEquals("En cours", $chantier->getStatus());
   }

   public function testSAddAndGetCompetence() {
       $chantier = new Chantier();
       $competence = new Competence();

       $chantier->addCompetence($competence);

       $this->assertCount(1, $chantier->getCompetences());
   }

   public function testRemoveCompetence() {
       $chantier = new Chantier();
       $competence = new Competence();

       $chantier->addCompetence($competence);
       $chantier->removeCompetence($competence);

       $this->assertCount(0, $chantier->getCompetences());
   }

    public function testAddAndGetMission()
    {
        $chantier = new Chantier();
        $mission = new Mission();

        $chantier->addMission($mission);

        $this->assertCount(1, $chantier->getMissions());
        $this->assertTrue($chantier->getMissions()->contains($mission));
        $this->assertEquals($chantier, $mission->getChantier());
    }

    public function testRemoveMission()
    {
        $chantier = new Chantier();
        $mission = new Mission();

        $chantier->addMission($mission);
        $chantier->removeMission($mission);

        $this->assertCount(0, $chantier->getMissions());
        $this->assertNull($mission->getChantier());
    }
}
