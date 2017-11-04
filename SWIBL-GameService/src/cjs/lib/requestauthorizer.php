<?php
namespace swibl;

class RequestAuthorizer {
    
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, 
        \Psr\Http\Message\ResponseInterface $response, 
        $next)
    {
        // Add authorization logic goes here.
        return $response->withStatus(401, "Unauthorized request");
        
        $response = $next($request, $response);

    }
    
}