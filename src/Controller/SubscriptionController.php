<?php

namespace App\Controller;

use App\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    public function add(Request $request, ValidatorInterface $validator): Response {

        $subscriptionName = $request->request->get('name');


            $subscripton = (new Subscription())->setName($subscriptionName)->setStartDate(new \DateTime());

            $error = $validator->validate($subscripton);

            if (count($error) > 0) {
                return $this->json(['success' => false], 400);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($subscripton);
            $em->flush();

      
                return $this->json(['success' => true, 'subscription' => $subscripton], 201);



    }


}