<?php
namespace App\Services\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ApiServiceInterface extends CrudServiceInterface {
    /**
     * Get all records
     *
     * @param array $conditions
     * @return ResponseInterface|array
     */
    public function getAll($conditions = []);

    /**
     * Get record by ID
     *
     * @param array $conditions
     * @param string $method
     * @return ResponseInterface|array
     */
    public function getByIds($conditions, $method = 'POST');

    /**
     *  Get a record by ID
     *
     * @param int $id
     * @return ResponseInterface|array
     */
    public function getById($id);

    /**
     * Create a record
     *
     * @param array $attributes
     * @return ResponseInterface|array
     */
    public function create($attributes);

    /**
     * Update a record
     *
     * @param int $id
     * @param array $attributes
     * @return ResponseInterface|array
     */
    public function update($id, $attributes);

    /**
     * Delete a record
     *
     * @param int $id
     * @param array $attributes
     * @return ResponseInterface|array
     */
    public function delete($id, array $attributes = []);

    /**
     * Search for records
     *
     * @param array $conditions
     * @param string $method
     * @return ResponseInterface|array
     */
    public function search($conditions, $method = 'GET');

    /**
     * Set response
     *
     * @param  bool  $isResponse 
     * 
     * @return  void
     */ 
    public function setResponse($isResponse = true);
}