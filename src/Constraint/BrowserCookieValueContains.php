<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\BrowserKit\AbstractBrowser;

final class BrowserCookieValueContains extends Constraint
{
    public function __construct(
        private readonly string $name,
        private readonly string $value,
        private readonly bool $raw = false,
        private readonly string $path = '/',
        private readonly ?string $domain = null,
    ) {
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
        $str .= sprintf(' containing the %svalue "%s"', $this->raw ? 'raw ' : '', $this->value);

        return $str;
    }

    /**
     * @param AbstractBrowser $browser
     */
    protected function matches($browser): bool
    {
        $cookie = $browser->getCookieJar()->get($this->name, $this->path, $this->domain);
        if (!$cookie) {
            return false;
        }

        return str_contains($this->raw ? $cookie->getRawValue() : $cookie->getValue(), $this->value);
    }

    /**
     * @param AbstractBrowser $browser
     */
    protected function failureDescription($browser): string
    {
        return 'the Browser '.$this->toString();
    }
}
