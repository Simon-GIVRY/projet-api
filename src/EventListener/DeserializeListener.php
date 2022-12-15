<?php

namespace App\EventListener;

use ApiPlatform\Symfony\EventListener\DeserializeListener as DecoratedListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;


class deserializeListener
{

    public function __construct(private DecoratedListener $decorated)
    {
        
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest(); 

        if ($request->isMethodCacheable() || $request->isMethod(Request::Method_DELETE)) {
        }
    }

}