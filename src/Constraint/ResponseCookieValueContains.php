<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

final class ResponseCookieValueContains extends Constraint
{
    public function __construct(private readonly string $name, private readonly string $value, private readonly string $path = '/', private readonly ?string $domain = null)
    {
    }

    public function toString(): string
    {
        $str = sprintf('has cookie "%s"', $this->name);
        if ('/' !== $this->path) {
            $str .= sprintf(' with path "%s"', $this->path);
        }
        if ($this->domain) {
            $str .= sprintf(' for domain "%s"', $this->domain);
        }
        $str .= sprintf(' containing the value "%s"', $this->value);

        return $str;
    }

    /**
     * @param Response $response
     */
    protected function matches($response): bool
    {
        $cookie = $this->getCookie($response);
        if (!$cookie) {
            return false;
        }

        return str_contains((string) $cookie->getValue(), $this->value);
    }

    /**
     * @param Response $response
     */
    protected function failureDescription($response): string
    {
        return 'the Response '.$this->toString();
    }

    protected function getCookie(Response $response): ?Cookie
    {
        $cookies = $response->headers->getCookies();

        $filteredCookies = array_filter($cookies, fn (Cookie $cookie) => $cookie->getName() === $this->name && $cookie->getPath() === $this->path && $cookie->getDomain() === $this->domain);

        return reset($filteredCookies) ?: null;
    }
}
