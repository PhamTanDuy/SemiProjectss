<?php

namespace App\Controller;

use App\Entity\Inventor;
use App\Entity\Genre;
use App\Entity\Water;
use App\Form\WaterType;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class WaterController extends AbstractController
{
    /**
     * @Route("/", name="water_list")
     */

    public function ListAction(ManagerRegistry $doctrine): Response
    {
        $waters = $doctrine->getRepository(Water::class)->findAll();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('water/index.html.twig', ['waters' => $waters,
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/add/waterByGenre/{id}", name="waterByGenre")
     */
    public function GenreAction(ManagerRegistry $doctrine, $id): Response
    {
        $genre = $doctrine->getRepository(Genre::class)->find($id);
        $waters = $genre->getWaters();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('water/index.html.twig', [
            'waters' => $waters,
            'genres' => $genres
        ]);

    }


    /**
     * @Route("admin/water/create", name="water_create", methods={"GET","POST"})
     */
    public function create(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $water = new Water();
        $form = $this->createForm(WaterType::class, $water);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('Image')->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                // Move the file to the directory where image are stored
                try {
                    $uploadedFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Cannot Upload'
                    );
                    // ... handle exception if something happens during file upload
                }
                $water->setImage($newFilename);

                $entitymanager = $doctrine->getManager();
                $entitymanager->persist($water);
                $entitymanager->flush();

                $this->addFlash(
                    'notice',
                    'New Water Added'
                );
                return $this->redirectToRoute('water_create');
            }
        }
        return $this->render('water/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/water/edit/{id}", name="app_edit_water")
     */
    public function edit(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $entitymanager = $doctrine->getManager();
        $water = $entitymanager->getRepository(Water::class)->find($id);
        $form = $this->createForm(WaterType::class, @$water);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($water);
            $entitymanager->flush();

            return $this->redirectToRoute('water_list', [
                'id' => $water->getId()
            ]);
        }
        return $this->renderForm('water/edit.html.twig', ['form' => $form,]);
    }
    public function saveChanges(ManagerRegistry $doctrine, $form, $request, $water)
    {
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $water->setName($request->request->get('water')['name']);
            $water->setGenre($request->request->get('water')['genre']);
            $water->setDescription($request->request->get('water')['description']);
            $water->setPrice($request->request->get('water')['price']);
            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($water);
            $entitymanager->flush();

            return true;
        }

        return false;
    }


    /**
     * @Route("admin/water/delete/{id}", name="app_delete_water")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entitymanager = $doctrine->getManager();
        $water = $entitymanager->getRepository(Water::class)->find($id);
        $entitymanager->remove($water);
        $entitymanager->flush();

        $this->addFlash(
            'notice',
            'Water Deleted'
        );

        return $this->redirectToRoute('water_list');
    }

}