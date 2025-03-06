<?php

namespace App\Tests\Entity;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Entity\Mission;
use PHPUnit\Framework\TestCase;

class MissionTest extends TestCase
{
    public function testSetAndGetDateDebut() {
        $mission = new Mission();
        $date = new \DateTime('2024-02-01');
        $mission->setDateDebut($date);
        $this->assertEquals($date, $mission->getDateDebut());
    }

    public function testSetAndGetDateFin() {
        $mission = new Mission();
        $date = new \DateTime('2024-01-01');
        $mission->setDateFin($date);
        $this->assertEquals($date, $mission->getDateFin());
    }

    public function testSetAndAddChantier() {
        $mission = new Mission();
        $chantier = new Chantier();

        $mission->setChantier($chantier);
        $this->assertEquals($chantier, $mission->getChantier());
    }

    public function testSetAndAddEmploye() {
        $mission = new Mission();
        $employe = new Employes();

        $mission->setEmploye($employe);
        $this->assertEquals($employe, $mission->getEmploye());
    }
}
