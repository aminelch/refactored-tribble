<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, YoutubeRepository $repository, EntityManagerInterface $manager): Response
    {
        $video = new Youtube; 

        $youtubeForm= $this->createForm(YoutubeType::class,$video);
        
        $youtubeForm->handleRequest($request);

        if($youtubeForm->isSubmitted() && $youtubeForm->isValid()){
            $video = $youtubeForm->getData(); 
            dump($video); 
            
            $manager->persist($video);
            $this->addFlash('success', "Video successfully added");
            
            return $this->redirectToRoute('app_home');
           

        }
        $videos=$repository->findAll(); 
        dump($videos);
        return $this->render('youtube/index.html.twig', [
            // 'videos' => 5,
            'videos'=> $repository->findAll(),
            'form'=>$youtubeForm->createView()
        ]);
    }


}
