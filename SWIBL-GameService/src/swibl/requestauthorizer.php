<?php
namespace swibl;

class RequestAuthorizer {
    
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, 
        \Psr\Http\Message\ResponseInterface $response, 
        $next)
    {

        // Authenticate the request.
        $authenticated = $this->authenticateRequest($request);
        if (!$authenticated) {
            return $response->withStatus(401,"Unauthorized request");
        }
            return $next($request, $response);

    }
    
    /**
     * This function will execute application specific logic to authenticate the incoming request to the service.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return boolean
     */
    function authenticateRequest(\Psr\Http\Message\ServerRequestInterface $request) {
       
       $service = GameService::getInstance();
       if ($service->isAuthenticationEnabled()) {
           // ADD AUTHENTICATION LOGIC HERE
            return false;
        } else {
            return true;
        }
    }
    
}