<?php

namespace App\Controller;

use App\Repository\DeathCauseRepository;
use App\Repository\DeathRepository;
use App\Service\DataGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private DataGenerator $dataGenerator;

    public function __construct(DataGenerator $dataGenerator)
    {
        $this->dataGenerator = $dataGenerator;
    }

    #[Route('/', name: 'app_home')]
    public function index(DeathRepository $deathRepository, DeathCauseRepository $deathCauseRepository): Response
    {
        try {
            if ($deathRepository->count() === 0) {
                $this->dataGenerator->importDataFromCSV();
            }
        } catch (\Exception $e) {
            echo "data not found. Error : " . $e;
        }

        $a = array(
            array("nom" => "rhone", "nombre" => 69),
            array("nom" => "loire", "nombre" => 42)
        ); // pour l'exemple, il faudra interroger la base
        $b = array(
            array("prenom" => "julien", "nombre" => 120),
            array("prenom" => "lilas", "nombre" => 240),
            array("prenom" => "merlvyn", "nombre" => 60)
        ); // pour l'exemple, il faudra interroger la base
        $c = array(
            array("mort" => "ovni", "nombre" => 111),
            array("mort" => "dinosaure", "nombre" => 222),
            array("mort" => "merlvyn", "nombre" => 1)
        ); // pour l'exemple, il faudra interroger la base
        $d = array("électrocuté", "écrasé", "d'un coup de foudre", "de mort :(", "d'une attaque d'extraterrestre", "d'une attaque de dinosaures", "noyé", "d'hésitation"); // pour l'exemple, il faudra interroger la base
        
        return $this->render('home/index.html.twig', [
            'deathsStats' => $deathRepository,
            'deathsCauses' => $deathCauseRepository,
            'controller_name' => 'HomeController',
            'topDepartements' => $a,
            'topPrenoms' => $b,
            'topMorts' => $c,
            'listeMorts' => $d,
        ]);
    }
}
