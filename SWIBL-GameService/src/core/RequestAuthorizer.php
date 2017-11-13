<?php
namespace swibl\core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use swibl\core\authentication\AuthDAO;

abstract class RequestAuthorizer {
    
    var $service = null;
    
    /**
     * @return the $service
     */
    public function getService()
    {
        return $this->service;
    }
    
    /**
     * @param field_type $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
    
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        $next)
    {
        
        $service = $this->getService();
        
        // Support a global permission for all GET requests.
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            return $next($request, $response);
        }
        
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
        $service = $this->getService();
        $db = $service->getDatabase();
        $logger = $service->getLogger();
        
        $clientid = $request->getHeaderLine("PHP_AUTH_USER");
        
        $dao = AuthDAO::getInstance($db);
        
        $logger->info("Authentication API call for " . $clientid);
        
        try {
            $token = $dao->getAUthToken($clientid);
            $secret = $token->getConsumersecret();
        } catch (\Exception $e) {
            $logger->info("Client " . $clientid . " did not have an authtoken granted");
            $secret="";
        }
        
        
        $signature = $request->getHeaderLine("HTTP_SIGNATURE");
        $nonce = $request->getHeaderLine("HTTP_NONCE");
        $key = $request->getHeaderLine("PHP_AUTH_PW");
        
        
        $calculated_signature = base64_encode(hash_hmac("sha256", $key . ":" . $nonce, $secret, True));
        
        if ($logger->getLevel() > 2) {
            $headers = $request->getHeaders();
            foreach ($headers as $name => $values) {
                $logger->debug($name . ": " . implode(", ", $values));
            }
            $logger->debug("REQUEST SIGNATURE /" . $request->getHeaderLine("HTTP_SIGNATURE"));
            $logger->debug("CALCULATED SIGNATURE = " . $calculated_signature);
        }
        
        if ($signature != $calculated_signature) {
            $logger->error("[Client " . $clientid . "] INVALID SIGNATURE ".$_SERVER['REQUEST_METHOD'] );
            return false;
        } else {
            $logger->debug("REQUEST SIGNATURE MATCHED");
        }
        
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if ($token->canPost()) return true;
                $logger->error("[Client " . $clientid . "] NOT AUTHORIZED FOR ".$_SERVER['REQUEST_METHOD'] . " OPERATION" );
                return false;
                break;
            case "PUT":
                if ($token->canPut()) return true;
                $logger->error("[Client " . $clientid . "] NOT AUTHORIZED FOR ".$_SERVER['REQUEST_METHOD'] . " OPERATION" );
                return false;
                break;
            case "DELETE":
                if ($token->canDelete()) return true;
                $logger->error("[Client " . $clientid . "] NOT AUTHORIZED FOR ".$_SERVER['REQUEST_METHOD'] . " OPERATION" );
                return false;
                break;
                
        }
        
        
        // Check SERVICE SPECIFIC AUTHORIZATION RULES
        if (!self::checkServiceAuthorizations($request)) {
            return false;
        }
        
        return true;
    }
    
    abstract function checkServiceAuthorizations(ServerRequestInterface $request);
    
}