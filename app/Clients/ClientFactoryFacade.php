<?php

    namespace App\Clients;

    use Illuminate\Support\Facades\Facade;

    class ClientFactoryFacade extends Facade
    {
        protected static function getFacadeAccessor()
        {
            return 'App\Clients\ClientFactory';
        }

    }