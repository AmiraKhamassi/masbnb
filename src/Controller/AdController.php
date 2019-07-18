<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads/{page?1}", name="ads_index")
     */
    public function index(AdRepository $repo, $page)
    {
        $limit = 6;

        $start = $page * $limit - $limit;

        $total = count($repo->findAll());

        $pages = ceil($total / $limit);
        
        return $this->render('ad/index.html.twig', [
            'paginate' => $pages,
            'ads' => $repo->findBy([], [], $limit, $start),
            'page' => $page
        ]);
    }
    
    /**
     * @Route("/ads/new", name="ads_create")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();

        $form = $this->createForm(AnnonceType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée");

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ads/show/{slug}", name="ads_show")
     */
    public function show( Ad $ad )
    {
        #$ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

    /**
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AnnonceType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifée");

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }       

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
