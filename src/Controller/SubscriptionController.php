<?php

namespace App\Controller;

use App\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends AbstractController
{
    public function list(): Response {

        $subscriptions = $this->getDoctrine()->getRepository(Subscription::class)->findAll();


        if (!$subscriptions) {
            return $this->json(['success' => false], 404);
        }

        $dataArray = [
            'success' => true,
            'subscriptions' => $subscriptions
        ];

        return $this->json($dataArray);
    }

    public function add(Request $request): Response {

        $subscriptionName = $request->request->get('name');

        if (is_string($subscriptionName)) {
            $subscripton = (new Subscription())->setName($subscriptionName)->setStartDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($subscripton);
            $em->flush();

            if ($subscripton->getId()) {
                return $this->json(['success' => true, 'subscription' => $subscripton], 201);
            }
        }



        return $this->json(['success' => false], 400);
    }


}