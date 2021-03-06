<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoft\Auth\Contract;

use Psr\Http\Message\ServerRequestInterface;

interface AuthServiceInterface
{
    /**
     * <code>
     * $controller = $this->getHandlerArray($requestHandler)[0];
     * $method = $this->getHandlerArray($requestHandler)[1];
     * $id = $this->getUserIdentity();
     * if ($id) {
     *     return true;
     * }
     * return false;
     * </code>
     *
     * @param string                 $requestHandler
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    public function auth(string $requestHandler, ServerRequestInterface $request): bool;
}
