<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\BrowserKit\AbstractBrowser;

final class BrowserCookieValueContains extends Constraint
{
    private string $name;
    private string $value;
    private bool $raw;
    private string $path;
    private ?string $domain;

    public function __construct(string $name, string $value, bool $raw = false, string $path = '/', ?string $domain = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->domain = $domain;
        $this->value = $value;
        $this->raw = $raw;
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
