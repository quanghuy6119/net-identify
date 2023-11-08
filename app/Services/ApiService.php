<?php 
namespace App\Services;

use App\Services\Contracts\ApiServiceInterface;
use App\Services\Proxy\HttpClientProxy;

abstract class ApiService extends Service implements ApiServiceInterface {
    /**
     * Http Client Proxy
     *
     * @var HttpClientProxy
     */
    protected HttpClientProxy $httpClient;

    /**
     * Base url
     *
     * @var string
     */
    protected ?string $baseUrl = '';

    /**
     * Prefix URI
     *
     * @var string
     */
    protected ?string $prefixUri = '';

    /**
     * Response
     *
     * @var string
     */
    protected bool $isResponse = false;

    /**
     * Content type
     *
     * @var string
     */
    protected string $contentType = '';

    public function __construct(HttpClientProxy $httpClient,
        string $baseUrl, string $prefixUri
    ){
        $this->httpClient = $httpClient;
        $this->setBaseUrl($baseUrl);
        $this->setPrefixUri($prefixUri);
    }

    /**
     * Create a record
     *
     * @param array $attributes
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function create($attributes) {
        $method = 'POST';
        $uri = $this->prefixUri;
        $params = $this->createParams($attributes, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     * Get all records
     *
     * @param array $conditions
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function getAll($conditions = []) {
        $method = 'GET';
        $uri = $this->prefixUri;
        $params = $this->createParams($conditions, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     *  Get a record by ID
     *
     * @param int $id
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function getById($id) {
        $method = 'GET';
        $uri = $this->prefixUri.'/'.$id;
        $res = $this->httpClient->request($method, $uri);
        return $this->response($res);
    }

    /**
     * Update a record
     *
     * @param int $id
     * @param array $attributes
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function update($id, $attributes) {
        $method = 'PUT';
        $uri = $this->prefixUri.'/'.$id;
        $params = $this->createParams($attributes, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @param array $attributes
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function delete($id, array $attributes = []) {
        $method = 'DELETE';
        $uri = $this->prefixUri.'/'.$id;
        $params = $this->createParams($attributes, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     * Get record by ID
     *
     * @param array $conditions
     * @param string $method
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function getByIds($conditions, $method = 'POST') {
        $uri = $this->prefixUri.'/ids';
        $params = $this->createParams($conditions, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     * Search for records
     *
     * @param array $conditions
     * @param string $method
     * @return ResponseInterface|\Illuminate\Http\Response
     */
    public function search($conditions, $method = 'GET') {
        $uri = $this->prefixUri.'/search';
        $params = $this->createParams($conditions, $method);
        $res = $this->httpClient->request($method, $uri, $params);
        return $this->response($res);
    }

    /**
     * Create http request parameters
     *
     * @param array  $attributes
     * @param string $method
     * @return array
     */
    protected function createParams($attributes, $method = 'GET')
    {
        switch ($this->contentType) {
            case 'application/json':
                return [
                    'body' => json_encode($attributes, JSON_FORCE_OBJECT)
                ];
            default:
                switch ($method) {
                    case 'GET':
                        return [
                            'query' => $attributes
                        ];
                        break;
                    default:
                        return [
                            'form_params' => $attributes
                        ];
                        break;
                }
        }
    }

    /**
     * Get body
     *
     * @param ResponseInterface $res
     * @param bool $isBaseResponse
     * @return array
     */ 
    protected function getBody($res, $isBaseResponse = false) {
        return $isBaseResponse ? json_decode($res->getContent(), true) : json_decode($res->getBody(), true);
    }

    /**
     * Set content type
     *
     * @param string $type 
     * @return void
     */ 
    public function setContentType($type = 'application/json') {
        $this->contentType = $type;
        $this->httpClient->contentType($type);
    }

    /**
     * Set response
     *
     * @param bool $isResponse 
     * @return void
     */ 
    public function setResponse($isResponse = true) {
        $this->isResponse = $isResponse;
    }

    /**
     * Response
     * 
     * @param ResponseInterface $res 
     * @return ResponseInterface|\Illuminate\Http\Response
     */ 
    public function response($res) {
        return $this->isResponse ? response($this->getBody($res), $res->getStatusCode()) : $res;
    }

    /**
     * Set base url
     *
     * @param  string  $baseUrl
     *
     * @return  self
     */ 
    public function setBaseUrl(string $baseUrl)
    {
        $this->httpClient->setBaseUrl($baseUrl);
        return $this;
    }

    /**
     * Get prefix URI
     *
     * @return  string
     */ 
    public function getPrefixUri()
    {
        return $this->prefixUri;
    }

    /**
     * Set prefix URI
     *
     * @param  string  $prefixUri  Prefix URI
     *
     * @return  self
     */ 
    public function setPrefixUri(string $prefixUri)
    {
        $this->prefixUri = $prefixUri;
        return $this;
    }
}