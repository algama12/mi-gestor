<?php

namespace App\Controller;

use App\Entity\Tarea;
use App\Form\TareaType;
use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/')]
class TareaController extends AbstractController
{
    #[Route('/', name: 'app_tarea_index', methods: ['GET'])]
    public function index(TareaRepository $tareaRepository, Request $request): Response
    {
        $response = $this->render('tarea/index.html.twig', [
            'tareas' => $tareaRepository->findAll(),
        ]);
    
        // Asegurarse de que la página no se almacene en caché
        $response->setPrivate();
        $response->setMaxAge(0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
    
        return $response;
    }

    #[Route('/new', name: 'app_tarea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TareaRepository $tareaRepository): Response
    {
        $tarea = new Tarea();
        $form = $this->createForm(TareaType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tareaRepository->save($tarea, true);

            return $this->redirectToRoute('app_tarea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tarea/new.html.twig', [
            'tarea' => $tarea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarea_show', methods: ['GET'])]
    public function show(Tarea $tarea): Response
    {
        return $this->render('tarea/show.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarea_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tarea $tarea, TareaRepository $tareaRepository): Response
    {
        $form = $this->createForm(TareaType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tareaRepository->save($tarea, true);

            return $this->redirectToRoute('app_tarea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tarea/edit.html.twig', [
            'tarea' => $tarea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarea_delete', methods: ['POST'])]
    public function delete(Request $request, Tarea $tarea, TareaRepository $tareaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarea->getId(), $request->request->get('_token'))) {
            $tareaRepository->remove($tarea, true);
        }

        return $this->redirectToRoute('app_tarea_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/cantidad-por-prioridad', name: 'app_cantidad_por_prioridad')]
    public function cantidadPorPrioridadAction(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Elemento::class);

        $alta = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.prioridad = :alta')
            ->setParameter('alta', 'alta')
            ->getQuery()
            ->getSingleScalarResult();

        $media = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.prioridad = :media')
            ->setParameter('media', 'media')
            ->getQuery()
            ->getSingleScalarResult();

        $baja = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.prioridad = :baja')
            ->setParameter('baja', 'baja')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('index.html.twig', [
            'alta' => $alta,
            'media' => $media,
            'baja' => $baja,
        ]);
    }
    


}
