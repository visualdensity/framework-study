<?php

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;


function is_leap_year($year) {
    if( null == $year ) {
        $year = date('Y');
    } 

    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

$routes = new Routing\RouteCollection();
$routes->add( 'hello', new Routing\Route( '/hello/{name}', array('name' => 'world')) );
$routes->add( 'bye'  , new Routing\Route( '/bye' ) );

$routes->add( 
    'is_leap_year', 
    new Routing\Route( 
        '/is_leap_year/{year}',
        array(
            'year' => null,
            '_controller' => function($request) {
                if( is_leap_year($request->attributes->get('year')) ) {
                    return new Response('Yes it is');
                } 
                return new Response('Nope');
            }
        )
    ) 
);

return $routes;
