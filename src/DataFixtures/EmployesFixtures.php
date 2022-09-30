<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EmployesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1 ; $i<5; $i++)
        {
           $employes=new Employes;
           $employes->setPrenom("Prenom de l'employe n°$i")
                     ->setNom("Nom de l'employe n°$i")
                     ->setTelephone(3688+$i)
                     ->setEmail("mail$i@gmail.com")
                     ->setAdresse("$i rue d'Aled")
                     ->setPoste("développeur")
                     ->setSalaire(2500*$i)
                     ->setDateDeNaissance(new \DateTime("12/25/1985"));
            $manager->persist($employes);

        }

        $manager->flush();
    }
      
}
