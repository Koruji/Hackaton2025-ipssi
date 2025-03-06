<?php

namespace App\Tests\Entity;

use App\Entity\Competence;
use App\Entity\Employes;
use App\Entity\Mission;
use PHPUnit\Framework\TestCase;

class EmployesTest extends TestCase
{
    public function testSetAndGetEmail() {
        $employe = new Employes();
        $employe->setEmail("test@test.com");
        $this->assertEquals("test@test.com", $employe->getEmail());
    }

    public function testSetAndGetRoles() {
        $employe = new Employes();
        $employe->setRoles(["ROLE_USER"]);
        $this->assertEquals("ROLE_USER", $employe->getRoles());
    }

    public function testSetAndGetPassword() {
        $employe = new Employes();
        $employe->setPassword("test");
        $this->assertEquals("test", $employe->getPassword());
    }

    public function testSetAndGetNom() {
        $employe = new Employes();
        $employe->setNom("Jean");
        $this->assertEquals("Jean", $employe->getNom());
    }

    public function testSetAndGetPrenom()
    {
        $employe = new Employes();
        $employe->setPrenom("Pierre");
        $this->assertEquals("Pierre", $employe->getPrenom());
    }

    public function testSetAndGetDisponibilite() {
        $employe = new Employes();
        $employe->setDisponible(true);
        $this->assertEquals(true, $employe->isDisponible());
    }

    public function testSetAndGetCompetence() {
        $employe = new Employes();
        $competence = new Competence();

        $employe->addCompetence($competence);
        $this->assertCount(1, $employe->getCompetences());
        $this->assertTrue($employe->getCompetences()->contains($competence));
    }

    public function testRemoveCompetence() {
        $employe = new Employes();
        $competence = new Competence();

        $employe->addCompetence($competence);
        $employe->removeCompetence($competence);
        $this->assertCount(0, $employe->getCompetences());
    }
    public function testSetAndGetMissions() {
        $employe = new Employes();
        $mission = new Mission();

        $employe->addMission($mission);
        $this->assertCount(1, $employe->getMissions());
        $this->assertTrue($employe->getMissions()->contains($mission));
    }

    public function testRemoveMissions() {
        $employe = new Employes();
        $mission = new Mission();

        $employe->addMission($mission);
        $employe->removeMission($mission);
        $this->assertCount(0, $employe->getMissions());
    }

}
