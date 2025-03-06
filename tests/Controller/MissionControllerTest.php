<?php

namespace App\Tests\Controller;

use App\Entity\Mission;
use App\Entity\Chantier;
use App\Entity\Employes;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;




final class MissionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $missionRepository;
    private string $path = '/dashboard/';

    // protected function setUp(): void
    // {
    //     $this->client = static::createClient();
    //     $this->manager = static::getContainer()->get('doctrine')->getManager();
    //     $this->missionRepository = $this->manager->getRepository(Mission::class);

    //     foreach ($this->missionRepository->findAll() as $object) {
    //         $this->manager->remove($object);
    //     }

    //     $this->manager->flush();
    // }

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();

        $this->createMission(new \DateTime('2024-03-06'), new \DateTime('2025-03-07'), 'Chantier 1', 'Nom9', 'Prenom9');
        $this->createMission(new \DateTime('2025-03-08'), new \DateTime('2025-03-09'), 'Chantier 2', 'Nom10', 'Prenom10');

    }

    private function createMission(\DateTime $dateDebut, \DateTime $dateFin, string $chantierNom, string $employeNom, string $employePrenom): void
    {
        $chantier = new Chantier();
        $chantier->setNom($chantierNom);
        
        $employe = new Employes();
        $employe->setNom($employeNom);
        $employe->setPrenom($employePrenom);
        $employe->setEmail(strtolower(str_replace(' ', '', $employeNom)) . '.' . strtolower($employePrenom) . '@test.com');
        $employe->setRoles(['ROLE_USER']); 
        $employe->setPassword(password_hash('password123', PASSWORD_BCRYPT));
        $employe->setDisponible(true); 

        $mission = new Mission();
        $mission->setDateDebut($dateDebut);
        $mission->setDateFin($dateFin);
        $mission->setChantier($chantier);
        $mission->setEmploye($employe);

        $this->manager->persist($chantier);
        $this->manager->persist($employe);
        $this->manager->persist($mission);
        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        
        self::assertPageTitleContains('BatiCrew');

        self::assertGreaterThan(0, $crawler->filter('table')->count());

        self::assertSelectorTextContains('td', 'Chantier 1');
        self::assertSelectorTextContains('td', 'Chantier 2');

        self::assertSelectorTextContains('td', 'Nom1');
        self::assertSelectorTextContains('td', 'Prenom1');
        self::assertSelectorTextContains('td', 'Nom2');
        self::assertSelectorTextContains('td', 'Prenom2');
    }


    // public function testIndex(): void
    // {
    //     $this->client->followRedirects();
    //     $crawler = $this->client->request('GET', $this->path);

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Mission index');

    //     // Use the $crawler to perform additional assertions e.g.
    //     // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    // }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'mission[dateDebut]' => 'Testing',
            'mission[dateFin]' => 'Testing',
            'mission[chantier]' => 'Testing',
            'mission[employe]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->missionRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Mission();
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setChantier('My Title');
        $fixture->setEmploye('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Mission');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Mission();
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setChantier('Value');
        $fixture->setEmploye('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'mission[dateDebut]' => 'Something New',
            'mission[dateFin]' => 'Something New',
            'mission[chantier]' => 'Something New',
            'mission[employe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/mission/');

        $fixture = $this->missionRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getChantier());
        self::assertSame('Something New', $fixture[0]->getEmploye());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Mission();
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setChantier('Value');
        $fixture->setEmploye('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/mission/');
        self::assertSame(0, $this->missionRepository->count([]));
    }
}
