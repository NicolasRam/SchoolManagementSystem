<?php
/**
 * Created by PhpStorm.
 * User: moula
 * Date: 18/08/2018
 * Time: 18:27
 */

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller\API
 *
 * @Route("/api")
 */
class APIController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @Route(
     *     "/books/call-to-action",
     *     name="api_call_to_action",
     *     defaults={
     *          "_api_item_operation_name"="count",
     *          "_api_receive"=false
     *      }
     * )
     * @return JsonResponse
     */
    public function callToAction()
    {
        return new JsonResponse(
            [
                'actions' =>
                    [
                        'title' => 'Open Discount For All',
                        'content' => 'Consectetur Adipisicing Elit Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore.',
                        'link' => '',
                    ]
            ]
        );
    }

    /**
     * @Route(
     *     "/books/latest-posts",
     *     name="api_latest_posts",
     *     defaults={
     *          "_api_item_operation_name"="latest_posts",
     *          "_api_receive"=false
     *      }
     * )
     * @return JsonResponse
     */
    public function latestPosts()
    {
        return new JsonResponse(
            [
                'posts' => []
            ]
        );
    }
}