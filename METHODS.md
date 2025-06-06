
# $this->assert method reference

For any `Not` asserts in Symfony use `expect()-not->isSuccessful()`

## $this->assert `Symfony\Component\HttpFoundation\Response`:

| Symfony                                                          | Pest                                                                       |
| ---------------------------------------------------------------- | -------------------------------------------------------------------------- |
| $this->assertResponseIsSuccessful()                              | expect($response)->isSuccessful()                                          |
| $this->assertResponseIsUnprocessable()                           | expect($response)->isUnprocessable()                                       |
| $this->assertResponseStatusCodeSame(int $code)                   | expect($response)->toHaveStatusCode(int $code)                             |
| $this->assertResponseFormatSame(string $format)                  | expect($response)->toHaveFormat(string $format)                            |
| $this->assertResponseRedirects(string $location)                 | expect($response)->toHaveRedirect(string $location)                        |
| $this->assertResponseHasHeader(string $key)                      | expect($response)->toHaveHeader(string $key)                               |
| $this->assertResponseHeaderSame(string $key, string $value)      | expect($response)->toHaveHeader(string $key, string $value)                |
|                                                                  | expect($response)->toHaveHeader(string $key, string $value, strict: false) |
| $this->assertResponseHasCookie(string $key)                      | expect($response)->toHaveCookie(string $key)                               |
| $this->assertResponseCookieValueSame(string $key, string $value) | expect($response)->toHaveCookie(string $key, string $value)                |
|                                                                  | expect($response)->toHaveCookie(string $key, string $value, strict: false) |

## Asset `Symfony\Component\DomCrawler\Crawler`:

| Symfony                                                          | Pest                                                                                       |
| ---------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| $this->assertSelectorExists(string $key)                         | expect($crawler)->toHaveSelector(string $key)                                              |
| $this->assertSelectorTextSame(string $key, string $value)        | expect($crawler)->toHaveSelector(string $key, string $value)                               |
| $this->assertSelectorTextContains(string $key, string $value)    | expect($crawler)->toHaveSelector(string $key, string $value, strict: false)                |
| $this->assertSelectorCount(int $count, string $key)              | expect($crawler)->toHaveSelectorCount(string $key, int $count)                             |
| $this->assertAnySelectorTextSame(string $key, string $value)     | expect($crawler)->toHaveAnySelector(string $key, string $value)                            |
| $this->assertAnySelectorTextContains(string $key, string $value) | expect($crawler)->toHaveAnySelector(string $key, string $value, strict: false)             |
| $this->assertPageTitleSame(string $value)                        | expect($crawler)->toHaveTitle(string $value)                                               |
| $this->assertPageTitleContains(string $value)                    | expect($crawler)->toHaveTitle(string $value, strict: false)                                |
| $this->assertInputValueSame(string $key, string $value)          | expect($crawler)->toHaveInput(string $key, string $value)                                  |
|                                                                  | expect($crawler)->toHaveInput(string $key, string $value, strict: false)                   |
| $this->assertCheckboxChecked(string $key)                        | expect($crawler)->toHaveCheckboxChecked(string $key)                                       |
| $this->assertFormValue(string $form, string $key, string $value) | expect($crawler)->toHaveFormInput(string $form, string $key, string $value)                |
|                                                                  | expect($crawler)->toHaveFormInput(string $form, string $key, string $value, strict: false) |

### Notes

`(int $count, string $key)` swap in `toHaveSelectorCount`.

## Asset `Symfony\Component\HttpFoundation\Request`:

| Symfony                                                            | Pest                                                                                |
| ------------------------------------------------------------------ | ----------------------------------------------------------------------------------- |
| $this->assertRequestAttributeValueSame(string $key, string $value) | expect($request)->toHaveRequestAttribute(string $key, string $value)                |
|                                                                    | expect($request)->toHaveRequestAttribute(string $key, string $value, strict: false) |
| $this->assertRouteSame(string $key, array $parameters = [])        | expect($request)->toHaveRequestRoute(string $key)                                   |
|                                                                    | expect($request)->toHaveRequestRoute(string $key, strict: false)                    |

### Notes

With the removal of `$parameters` chain `toHaveRequestAttribute` instead:

```
expect()
    ->toHaveRequestAttribute('key1', 'value2')
    ->toHaveRequestAttribute('key2', 'value2');
```

## $this->assert `Symfony\Component\BrowserKit\AbstractBrowser`:

| Symfony                                                         | Pest                                                                           |
| --------------------------------------------------------------- | ------------------------------------------------------------------------------ |
| $this->assertBrowserHasCookie(string $key, string $value)       | expect($client)->toHaveClientCookie(string $key, string $value)                |
| $this->assertBrowserCookieValueSame(string $key, string $value) | expect($client)->toHaveClientCookie(string $key, string $value)                |
|                                                                 | expect($client)->toHaveClientCookie(string $key, string $value, strict: false) |
