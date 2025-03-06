<?php

namespace App\Tests\Entity;

use App\Entity\Chantier;
use App\Entity\Competence;
use App\Entity\Employes;
use PHPUnit\Framework\TestCase;

class CompetenceTest extends TestCase
{
    public function testSetAndGetNom() {
        $competence = new Competence();
        $competence->setNom("Maconnerie");
        $this->assertEquals("Maconnerie", $competence->getNom());
    }

    public function testAddAndGetEmployes() {
        $competence = new Competence();
        $employes = new Employes();

        $competence->addEmploye($employes);
        $this->assertCount(1, $competence->getEmployes());
    }

    public function testAddAndGetChantiers() {
        $competence = new Competence();
        $chantier = new Chantier();

        $competence->addChantier($chantier);
        $this->assertCount(1, $competence->getChantiers());
    }

    public function testRemoveEmploye() {
        $competence = new Competence();
        $employes = new Employes();

        $competence->addEmploye($employes);
        $competence->removeEmploye($employes);
        $this->assertCount(0, $competence->getEmployes());
    }

    public function testRemoveChantier() {
        $competence = new Competence();
        $chantier = new Chantier();

        $competence->addChantier($chantier);
        $competence->removeChantier($chantier);
        $this->assertCount(0, $competence->getChantiers());
    }
}
