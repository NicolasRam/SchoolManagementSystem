<?php
/**
 * Created by PhpStorm.
 * User: moula
 * Date: 18/08/2018
 * Time: 18:27
 */

namespace App\Controller\API;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 * @package App\Controller\API
 *
 * @Route("/api/books")
 */
class BookController extends Controller
{
    /**
     * Count action
     *
     * @Route(
     *     "/count",
     *     name="api_book_count",
     *     defaults={
     *          "#_api_resource_class"=Book::class,
     *          "_api_item_operation_name"="count",
     *          "_api_receive"=false
     *      }
     * )
     *
     * @param BookRepository $bookRepository
     * @return JsonResponse
     *
     */
    public function count( BookRepository $bookRepository )
    {
        $booksCount = $bookRepository->count([]);

        return new JsonResponse( [ 'booksCount' => $booksCount ] );
    }
}