<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftTest\Auth\UnitParser;

use Swoft;
use Swoft\Auth\AuthUserService;
use Swoft\Auth\Contract\AuthManagerInterface;
use Swoft\Auth\Contract\AuthServiceInterface;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Router\HandlerMapping;
use SwoftTest\Auth\UnitAbstractTestCase;
use SwoftTest\Auth\UnitManager\TestManager;

class BearerTokenParserTest extends AbstractTestCase
{
    protected function registerRoute()
    {
        /** @var HandlerMapping $router */
        $router = Swoft::getBean('httpRouter');
        $router->get('/bearer', function (Request $request) {
            /** @var AuthUserService $service */
            $service = Swoft::getBean(AuthServiceInterface::class);
            $session = $service->getSession();
            return ['id' => $session->getIdentity()];
        });
    }

    /**
     * @covers AuthManager::authenticateToken()
     * @covers BearerTokenHandler::handle()
     * @covers AuthUserService::getSession()
     */
    public function testHandle()
    {
        /** @var TestManager $manager */
        $manager = Swoft::getBean(AuthManagerInterface::class);
        $session = $manager->testLogin('user', '123456');
        $token = $session->getToken();
        $response = $this->request('GET', '/bearer', [], self::ACCEPT_JSON, ['Authorization' => 'Bearer ' . $token], '');
        $res = $response->getBody()->getContents();
        $this->assertEquals(json_decode($res, true), ['id' => 1]);
    }
}
