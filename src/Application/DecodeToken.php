<?php

namespace Application;

use Firebase\JWT\JWT;
use Interfaces\Exceptions\InvalidJwtTokenException;
use Application\DataTransferObject\TokenDTO;
use Application\Validators\TokenValidator;

class DecodeToken
{
    private $tokenValidator;

    public function __construct(TokenValidator $validator)
    {
        $this->tokenValidator = $validator;
    }

    public function execute(TokenDTO $dto)
    {
        $dto = $this->tokenValidator->sanitize($dto);
        $this->tokenValidator->validate($dto);

        try {
            $payload = JWT::decode($dto->client_token, config('jwt.secret'), ['HS256']);
            if (!isset($payload->id)) {
                throw new \Exception('required id is missing in payload');
            }
        } catch (\Exception $e) {
            throw new InvalidJwtTokenException($e);
        }

        return $payload;
    }
}
