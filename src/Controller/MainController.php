<?php

namespace App\Controller;
use App\Entity\Inventor;
use App\Entity\Genre;
use App\Entity\Water;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/add/water_view/{id}", name="app_view_water")
     */
    public function Show(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, int $id, Water $water): Response
    {
        $water = $doctrine->getRepository(Water::class)->findWater($id);
        $genre = $doctrine->getRepository(Genre::class)->findAll();
        $inventor = $doctrine->getRepository(Inventor::class)->findAll();

        return $this->render('main/view.html.twig', array(
            'water' => $water,
            'genre' => $genre,
            'inventor' => $inventor,
        ));
    }
}

