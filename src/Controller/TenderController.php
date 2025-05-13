<?php

namespace App\Controller;

use App\Entity\Tender;
use App\Form\TenderTypeForm;
use App\Repository\TenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TenderController extends AbstractController
{
    #[Route('/', name: 'app_tender')]
    public function index(Request $request, TenderRepository $tenderRepository, PaginatorInterface $paginator): Response
    {
        // Получаем query-параметры
        $name = $request->query->get('name');
        $date = $request->query->get('date');

        $errors = [];

        // проверка соответствия даты
        if ($date) {
            $d = \DateTime::createFromFormat('Y-m-d', $date);
            if (!$d || $d->format('Y-m-d') !== $date) {
                $errors[] = 'Некорректный формат даты. Используйте YYYY-MM-DD.';
                $date = null;
            }
        }

        // Используем метод поиска с фильтрацией
        $queryBuilder = $tenderRepository->getQueryBuilderByFilters($name, $date);

        // Используем пагинатор
        $pagination = $paginator->paginate(
            $queryBuilder,                         // query or queryBuilder
            $request->query->getInt('page', 1),    // текущая страница, по умолчанию 1
            10                                     // элементов на страницу
        );

        return $this->render('tender/index.html.twig', [
            'pagination' => $pagination,
            'filter_name' => $name,
            'filter_date' => $date,
            'errors' => $errors,
        ]);
    }

    #[Route('/tender/new', name: 'app_tender_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $tender = new Tender();

        $form = $this->createForm(TenderTypeForm::class, $tender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tender);
            $em->flush();

            $this->addFlash('success', 'Тендер успешно добавлен');
            return $this->redirectToRoute('app_tender');
        }

        return $this->render('tender/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tender/{id}', name: 'app_tender_show')]
    public function show(Tender $tender): Response
    {
        return $this->render('tender/show.html.twig', [
            'tender' => $tender,
        ]);
    }

    /*public function getTender(Request $request, EntityManagerInterface $entityManager):JsonResponse
    {
        $name = $request->get('name');
        $date = $request->get('date');

        $qb = $entityManager->getRepository(Tender::class)->createQueryBuilder('tender');

        if ($name) {
            $qb->andWhere('tender.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        // Фильтруем по дате
        if ($date) {
            $qb->andWhere('tender.updatedAt >= :date')
                ->setParameter('date', new \DateTime($date));
        }

        // Получаем результаты
        $tenders = $qb->getQuery()->getResult();

        // Преобразуем данные в массив для ответа
        $tendersArray = array_map(function($tender) {
            return [
                'id' => $tender->getId(),
                'number' => $tender->getNumber(),
                'status' => $tender->getStatus(),
                'name' => $tender->getName(),
                'updatedAt' => $tender->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $tenders);

        return new JsonResponse($tendersArray);
    }*/



}
