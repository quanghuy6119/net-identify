<?php

namespace App\Domain\Exceptions;

/**
 * Logs:
 *   - Edit deleteById(): Add 2 params $code, $previous to __constructor() (BaoHoa - 2023/07/03) 
 * Updated at: 2023-07-03
 */
class DatabaseException extends \Exception{
    public function __construct($message, int $code = 0, $previous = null){
        parent::__construct($message, $code, $previous);
    }
}