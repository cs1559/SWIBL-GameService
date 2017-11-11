<?php
namespace swibl;

class RequestAuthorizer {
    
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, 
        \Psr\Http\Message\ResponseInterface $response, 
        $next)
    {

        $service = GameService::getInstance();
        
        if ($service->isAuthenticationEnabled()) {
            // Authenticate the request.
            $authenticated = $this->authenticateRequest($request);
            if (!$authenticated) {
                return $response->withStatus(401,"Unauthorized request");
            }
        }
        return $next($request, $response);
    }
    
    /**
     * This function will execute application specific logic to authenticate the incoming request to the service.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return boolean
     */
    function authenticateRequest(\Psr\Http\Message\ServerRequestInterface $request) {
        $signature = $request->getHeaderLine("HTTP_SIGNATURE");
        $nonce = $request->getHeaderLine("HTTP_NONCE");
        $key = $request->getHeaderLine("PHP_AUTH_PW");
        $secret = "394592742SASDNVxcwe23923";
        $calculated_signature = base64_encode(hash_hmac("sha256", $key . ":" . $nonce, $secret, True));

        if ($signature != $calculated_signature) {
            return false;
        }
        
        $service = GameService::getInstance();
        if ($service->isLogEnabled()) {
            $logger = $service->getLogger();
            
            $headers = $request->getHeaders();
            foreach ($headers as $name => $values) {
                $logger->write($name . ": " . implode(", ", $values));
            }
            
            if ($logger->getLevel() > 2) {
                $logger->info("REQUEST SIGNATURE /" . $request->getHeaderLine("HTTP_SIGNATURE"));
                $logger->info("CALCULATED SIGNATURE = " . $calculated_signature);
            }
        }
        
        if ($service->isAuthenticationEnabled()) {
            // ADD AUTHENTICATION LOGIC HERE
            return false;
        } else {
            return true;
        }
    }
    
}