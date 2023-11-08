<?php
namespace App\Utilities\Helpers;

use App\Domain\Exceptions\InvalidArgumentException;
use App\Utilities\Container\ContainerTrait;
use Exception;

class JobDispatcher
{
    use ContainerTrait;

    /**
     * Instance of dispatcher
     * @var JobDispatcher
     */
    private static $instance;

    /**
     * Get the dispatcher instance.
     *
     * @return JobDispatcher  An instance of the job dispatcher.
     */
    private function getInstance() 
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get the job class by type.
     *
     * @param string $type          A type of job
     * @param array  $payload       Array of param to dispatch
     * @param array  $queues        Array of queue
     * @return void
     * @throws InvalidArgumentException 
     */
    public static function dispatch(string $type, array $payload = [], array $queues = [])
    {
        $job = self::getInstance()->createJob($type, $payload);

         if ($queues) {
            foreach($queues as $queue) {
                dispatch($job)->onQueue($queue);
            }

        } else {
            dispatch($job);
        }
    }

    /**
     * Get the job class by type.
     *
     * @param string $type   A type of job
     * @return string        An name of the job class.
     */
    private function getJobClassName($type)
    {
        switch($type) {
            default:
                return null;
        }
    }

    /**
     * Create the job class.
     *
     * @param string $type      A type of job
     * @param array  $payload   Array of param to dispatch
     * @return mixed An instance of job
     * @throws InvalidArgumentException 
     */
    private function createJob($type, $payload)
    {
        $className = $this->getJobClassName($type);
        if (!$className) throw new InvalidArgumentException($type, "Job type is invalid, type is not register");

        try {
            return $this->resolve($className, ["payload" => $payload]);

        } catch(\Throwable $e) {
            throw new Exception("Create job failed");
        }
    }
}