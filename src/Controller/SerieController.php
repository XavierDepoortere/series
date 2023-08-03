<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class SerieController extends AbstractController
{
    #[Route('/series', name: 'serie_list')]
    public function list(SerieRepository $serieRepository): Response
    {

        $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], limit: 30);
        

        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/series/details{id}', name: 'serie_details')]
    public function details(int $id, SerieRepository $serieRepository): Response
    {

        $serie = $serieRepository->find($id);
        return $this->render('serie/details.html.twig', [
            "serie" => $serie
        ]);
    }

    #[Route('/series/create', name: 'serie_create')]
    public function create(): Response
    {
        return $this->render('serie/create.html.twig', [
            
        ]);
    }

    #[Route('/series/demo', name: 'em_demo')]
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //créer une instance de mon entité
        $serie = new Serie();

        //importer toutes les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('dafsd');
        $serie->setPoster('dafsd');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(NEW \DateTime("- 1 year"));
        $serie->setLastAirDate(NEW \DateTime(" -6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('bla bla bla');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('Canceled');
        $serie->setTmdbId(329432);

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);
        $serie->setGenres('comedy');
        
        $entityManager->flush();




        return $this->render('serie/create.html.twig', [
            
        ]);
    }
}
