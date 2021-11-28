<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PaymentType;
use App\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentTypeController extends AbstractController
{
    public function list(): Response
    {
        $paymentTypes = $this->getDoctrine()->getRepository(PaymentType::class)->findAll();
        return $this->json(['paymentTypes' => $paymentTypes]);
    }

    public function create(Request $request, ValidatorInterface $validator): Response {

        $paymentType = (new PaymentType())->setName($name)->setDescription($description);

        $error = $validator->validate($paymentType);

        if (count($error) > 0) {
            return $this->json(['success' => false], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($paymentType);
        $em->flush();


        return $this->json(['success' => true, 'paymentType' => $paymentType], 201);



    }


    public function read(): Response {

    }

    public function update(int $id, Request $request, ValidatorInterface $validator): Response {

        $paymentType = new PaymentType();

        $this->setDataToPaymentType($request->request->all(), $paymentType);

        if(!$paymentType) {
            return $this->json([], 404);
        }

        $requestData = $request->request->all();
        $this->setDataToPaymentType($requestData, $paymentType);


        $name = $request->request->all();
        $description = $request->request->get('description', '');


        $error = $validator->validate($paymentType);

        if (count($error) > 0) {
            return $this->json(['success' => false], 400);
        }


        $em = $this->getDoctrine()->getManager();
        $em->flush();


        return $this->json(['success' => true, 'paymentType' => $paymentType], 201);
    }

    public function delete(): Response {

    }

    protected function setDataToPaymentType(array $requestData, $paymentType)
    {
        foreach ($requestData as $key => $data) {
            $methodName = 'set' . ucfirst($key)
            if (!empty($data) && method_exists($paymentType,$methodName )) {
                $paymentType->{$methodName}($data);
            }
        }
    }

}