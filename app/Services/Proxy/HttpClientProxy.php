<?php
namespace App\Services\Proxy;

use App\Domain\Exceptions\ServiceException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class HttpClientProxy implements ClientInterface{

    private ClientInterface $client;

    private string $baseUrl;

    private array $headers = [];

    public function __construct(ClientInterface $client){
        $this->client = $client;
        $this->baseUrl = "";
        $this->acceptType();
    }

    public function acceptType($type = 'application/json'){
        $this->headers["headers"]['Accept'] = $type; 
        return $this;
    }

    public function contentType($type = 'application/json'){
        $this->headers["headers"]['Content-Type'] = $type; 
        return $this;
    }

    public function withBaseUrl($baseUrl){
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function useBearerToken($token){
        $this->headers["headers"]['Authorization'] = 'Bearer ' . $token;
        return $this;
    }

    private function modifyOptions(array $options = []){
        return array_merge($this->headers, $options);
    }

    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @throws GuzzleException
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface{
        $options = $this->modifyOptions($options);
        return $this->client->send($request, $options);
    }

    /**
     * Asynchronously send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     */
    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface{
        $options = $this->modifyOptions($options);
        return $this->client->sendAsync($request, $options);
    }

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string              $method  HTTP method.
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface{
        $options = $this->modifyOptions($options);

        try {
            return $this->client->request($method, $this->baseUrl.$uri, $options);
        }
        catch (ServerException $ex){
            return $ex->getResponse();
        }
        catch (ClientException $ex){
            return $ex->getResponse();
        }
        catch(GuzzleException $ex){
            throw new ServiceException("Request failed ".$ex->getMessage());
        }
    }
    
    /**
     * Create and send an asynchronous HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well. Use an array to provide a URL
     * template and additional variables to use in the URL template expansion.
     *
     * @param string              $method  HTTP method
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     */
    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface{
        $options = $this->modifyOptions($options);

        return $this->client->requestAsync($method, $this->baseUrl.$uri, $options);
    }

    /**
     * Get a client configuration option.
     *
     * These options include default request options of the client, a "handler"
     * (if utilized by the concrete client), and a "base_uri" if utilized by
     * the concrete client.
     *
     * @param string|null $option The config option to retrieve.
     *
     * @return mixed
     *
     * @deprecated ClientInterface::getConfig will be removed in guzzlehttp/guzzle:8.0.
     */
    public function getConfig(?string $option = null){
        return $this->client->getConfig($option);
    }

    /**
     * Set the value of baseUrl
     *
     * @return  self
     */ 
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}
