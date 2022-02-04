<?php

namespace Fintech\Simplify\Exception;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ValidatorErrorExeption extends \RuntimeException implements ProblemDetailsExceptionInterface {
    use CommonProblemDetailsExceptionTrait;

    public function __construct($type, $title, $detail, int $status)
    {
        $this->type = $type;
        $this->title  = $title;
        $this->detail = $detail;
        $this->status = $status;
        parent::__construct($this->detail, $this->status);
    }
}

