<?php declare(strict_types=1);

namespace BalticRobo\Api\Service\User\Jwt;

use BalticRobo\Api\Model\User\TokenDataDTO;
use BalticRobo\Api\Model\User\TokenDTO;

interface JwtAuthInterface
{
    public function encode(TokenDataDTO $dto): TokenDTO;
    public function decode(TokenDTO $dto): TokenDataDTO;
    public function decodeToRefresh(TokenDTO $dto): TokenDataDTO;
    public function verify(TokenDTO $dto): bool;
}
