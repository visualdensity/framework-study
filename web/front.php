<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Routing;

function render_template($request) {
    extract( $matcher->match($request->getPathInfo()), EXTR_SKIP );
    ob_start();
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

    $response = new Response( ob_get_clean() );
}

//create a request object and get routes
$request = Request::createFromGlobals();
$routes  = include __DIR__ . '/../src/app.php';


//create context
$request_context = new Routing\RequestContext();
$request_context->fromRequest($request);

$matcher = new Routing\Matcher\UrlMatcher($routes, $request_context);

try {
    //add the matched results to $request->attributes
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
}
catch ( Routing\Exception\ResourceNotFoundException $e ) {
    $response = new Response( 'Where?!', 404 );
}
catch ( Routing\Exception\MethodNotFoundException $e ) {
    $response = new Response( 'Me no speak English', 500 );
}

$response->send();
