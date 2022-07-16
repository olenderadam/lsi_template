<?php

namespace App\Controller;

use App\Entity\HistoryLog;
use App\Form\HistoryLogType;
use App\Repository\HistoryLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


#[Route('/history/log')]
class HistoryLogController extends AbstractController
{
    #[Route('/', name: 'app_history_log_index', methods: ['GET'])]
    public function index(Request $request,  HistoryLogRepository $historyLogRepository): Response
    {
        //$form_search = $this->createForm(LogSearchType::class, []);

        $form_search = $this->createFormBuilder()
            ->setMethod('GET')
            ->add(
                'export_name',
                ChoiceType::class,
                [
                    'choices'  => $historyLogRepository->getNames(),
                    'label' => false,

                ]
            )
            ->add(
                'date_from',
                DateType::class,
                [
                    'placeholder' => 'Select a value',
                    'widget' => 'single_text',
                    'label' => false,
                ]
            )
            ->add('date_to', DateType::class,  ['widget' => 'single_text',  'label' => false,])
            ->getForm();

        $form_search->handleRequest($request);

        if ($criteria = $form_search->getData()) {
            $data = $historyLogRepository->findByFilterCrit($criteria);
        } else {
            $data = $historyLogRepository->findAll();
        }
        return $this->renderForm('history_log/index.html.twig', [
            'history_logs' => $data, //findBy(['export_name'=>$request->get('export_name')]),
            'form_search' => $form_search,

        ]);
    }

    #[Route('/new', name: 'app_history_log_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HistoryLogRepository $historyLogRepository): Response
    {
        $historyLog = new HistoryLog();
        $form = $this->createForm(HistoryLogType::class, $historyLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historyLogRepository->add($historyLog, true);

            return $this->redirectToRoute('app_history_log_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('history_log/new.html.twig', [
            'history_log' => $historyLog,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_history_log_show', methods: ['GET'])]
    public function show(HistoryLog $historyLog): Response
    {
        return $this->render('history_log/show.html.twig', [
            'history_log' => $historyLog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_history_log_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HistoryLog $historyLog, HistoryLogRepository $historyLogRepository): Response
    {
        $form = $this->createForm(HistoryLogType::class, $historyLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historyLogRepository->add($historyLog, true);

            return $this->redirectToRoute('app_history_log_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('history_log/edit.html.twig', [
            'history_log' => $historyLog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_log_delete', methods: ['POST'])]
    public function delete(Request $request, HistoryLog $historyLog, HistoryLogRepository $historyLogRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $historyLog->getId(), $request->request->get('_token'))) {
            $historyLogRepository->remove($historyLog, true);
        }

        return $this->redirectToRoute('app_history_log_index', [], Response::HTTP_SEE_OTHER);
    }
}
