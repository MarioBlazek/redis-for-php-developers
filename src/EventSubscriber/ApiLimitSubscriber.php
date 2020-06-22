<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\ApiLimitReachedException;
use App\Security\User;
use App\Value\Customer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiLimitSubscriber extends GenericApiLimit implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');

        if (!mb_strpos($routeName, self::SECURE_ROUTE_PREFIX) === 0) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        $customer = new Customer($user->getId());

        try {
            $this->limiterService->hit($customer, self::EVERY_MINUTE, self::MAX_HITS_PER_MINUTE);
        } catch (ApiLimitReachedException $exception) {
            $response = new JsonResponse('Too many requests', Response::HTTP_TOO_MANY_REQUESTS);
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
