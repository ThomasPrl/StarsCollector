<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Star;
use App\Entity\Space;
use App\Entity\Member;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }


    /**
     * Generates initialization data for stars : [description, type, mass, temperature, diameter, space]
     * @return \\Generator
     */
  
    private static function starsDataGenerator()
    {
        yield ["Soleil", ["Naine Jaune", "Naine Rouge"], 1, 5772, 1, "Inventaire d'étoiles de Thomas"];
        yield ["Alpha Centauri A", ["Naine Jaune"], 1.1, 5800, 1.227, "Voie Lactée"];
        yield ["Alpha Centauri B", ["Naine Brune"], 0.907, 5267, 0.865, "Voie Lactée"];
        yield ["Sirius", ["Naine Rouge"], 2.12, 24800, 1, "Voie Lactée"];
    }

    /**
     * Generates initialization data for spaces (cluster) : [description, member]
     * @return \\Generator
     */

    private static function spaceDataGenerator()
    {
        yield ["Inventaire d'étoiles de Thomas", "Thomas"];
        yield ["Voie Lactée", "Alexandre"];
        yield ["Draco II", "Alexandre"];
        yield ["Tucana III", "Thomas"];
    }


    /**
     * Generates initialization data for members (cluster) : [name, description]
     * @return \\Generator
     */


    private static function memberDataGenerator()
    {
        yield ["Thomas", "thomas@localhost"];
        yield ["Alexandre", "alexandre@localhost"];
    }


    /**
     * Generates initialization data for types (cluster) : [name, description]
     * @return \\Generator
     */

    private static function typeDataGenerator()
    {
        yield ["Naine", "", null];
        yield ["Naine Jaune", "Ce sont des étoiles de taille moyenne.", "Naine"];
        yield ["Naine Brune", "Ce sont des étoiles avortées. Leur masse est située entre celles des petites étoiles et des grosses planètes. Pas assez en tout cas pour que démarre les réaction de fusion nucléaire qui font les étoiles", "Naine"];
        yield ["Naine Rouge", "Ce sont les plus petites étoiles. Leur masse est comprise entre 0,08 et 0,8 masse solaire.", "Naine"];
    }

    public function load(ObjectManager $manager): void
   {

        $parentRepo = $manager->getRepository(Type::class);

        foreach (self::typeDataGenerator() as [$label, $desc, $parent]){
            $type = new Type();
            $type->setLabel($label);
            $parents = $parentRepo->findOneBy(["parent"=>$parent]);
            $type->setParent($parents);
            $type->setDescription($desc);
            $this->addReference($label, $type);
            $manager->persist($type);
            $manager->flush();
        } 

        dump("TypeCategorie OK ✅");

    

        foreach (self::memberDataGenerator() as [$name, $useremail]){
            $member = new Member();
            if ($useremail){
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                $member->setUser($user);
            }
            $member->setName($name);
            $manager->persist($member);
        } 
        $manager->flush();
        dump("Member OK ✅");


        $memberRepo = $manager->getRepository(Member::class);

        foreach (self::spaceDataGenerator() as [$desc, $memberName]){
            $member = $memberRepo->findOneBy(["name"=>$memberName]);
            $space = new Space();
            $space->setDescription($desc);
            $member->addSpace($space);
            $manager->persist($space);
        }
        $manager->flush();
        dump("Space OK ✅");
               

        $spaceRepo = $manager->getRepository(Space::class);
        //$typeRepo = $manager->getRepository(Type::class);

        foreach (self::starsDataGenerator() as [$desc, $types ,$mass, $temp, $diam, $descSpace]){
            $space = $spaceRepo->findOneBy(["description"=>$descSpace]);
            $star = new Star();
            $star->setDescription($desc);
            foreach ($types as $t){
                $star->addType($this->getReference($t));
            }
            $star->setMass($mass);
            $star->setTemperature($temp);
            $star->setDiameter($diam);
            $star->setSpace($space);
            $manager->persist($star);
        }
        $manager->flush();
        dump("Star OK ✅");

        dump("SUCCESS LOAD");
    }

}

