<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/phones")
 */
class PhoneController extends AbstractController
{
    /**
     * @Route("/{page<\d+>?1}", name="list_phone", methods={"GET"})
     */
    public function index(Request $request, PhoneRepository $phoneRepository, SerializerInterface $serializer)
    {
        $page = $request->query->get('page');
        if(is_null($page) || $page < 1) {
            $page = 1;
        }

        $phones = $phoneRepository->findAllPhones($page, getenv('LIMIT'));
        $data = $serializer->serialize($phones, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}