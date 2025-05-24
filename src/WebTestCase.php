<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pest\Symfony;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * WebTestCase is the base class for functional tests.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class WebTestCase extends KernelTestCase
{
    protected static ?AbstractBrowser $client;

    protected function tearDown(): void
    {
        parent::tearDown();
        self::$client = null;
    }

    /**
     * Creates a KernelBrowser.
     *
     * @param array $options An array of options to pass to the createKernel method
     * @param array $server  An array of server parameters
     */
    public static function createClient(array $options = [], array $server = []): KernelBrowser
    {
        if (static::$booted) {
            throw new \LogicException(sprintf('Booting the kernel before calling "%s()" is not supported, the kernel should only be booted once.', __METHOD__));
        }

        $kernel = static::bootKernel($options);

        try {
            $client = $kernel->getContainer()->get('test.client');
        } catch (ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new \LogicException('You cannot create the client used in functional tests if the "framework.test" config is not set to true.');
            }
            throw new \LogicException('You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".');
        }

        $client->setServerParameters($server);

        return self::getClient($client);
    }

    public static function getClient(?AbstractBrowser $newClient = null): ?AbstractBrowser
    {
        if (0 < \func_num_args()) {
            self::$client = $newClient;
        }

        if (!self::$client instanceof AbstractBrowser) {
            static::fail(sprintf('A client must be set to make assertions on it. Did you forget to call "%s::createClient()"?', __CLASS__));
        }

        return self::$client;
    }

    public static function getResponse(): Response
    {
        if (!$response = self::getClient()->getResponse()) {
            static::fail('A client must have an HTTP Response to make assertions. Did you forget to make an HTTP request?');
        }

        return $response;
    }

    public static function getRequest(): Request
    {
        if (!$request = self::getClient()->getRequest()) {
            static::fail('A client must have an HTTP Request to make assertions. Did you forget to make an HTTP request?');
        }

        return $request;
    }

    private static function getCrawler(): Crawler
    {
        if (!$crawler = self::getClient()->getCrawler()) {
            static::fail('A client must have a crawler to make assertions. Did you forget to make an HTTP request?');
        }

        return $crawler;
    }
}
