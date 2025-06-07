
# Assert method mapping

For any `Not` asserts in Symfony use `expect()-not->toBeSuccessful()`

## Assert `Symfony\Component\HttpFoundation\Response`:

| Symfony                                                          | Pest                                                                       |
| ---------------------------------------------------------------- | -------------------------------------------------------------------------- |
| $this->assertResponseIsSuccessful()                              | expect($response)->toBeSuccessful()                                        |
| $this->assertResponseIsUnprocessable()                           | expect($response)->toBeUnprocessable()                                     |
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

## Assert `Symfony\Component\BrowserKit\AbstractBrowser`:

| Symfony                                                         | Pest                                                                           |
| --------------------------------------------------------------- | ------------------------------------------------------------------------------ |
| $this->assertBrowserHasCookie(string $key, string $value)       | expect($client)->toHaveClientCookie(string $key, string $value)                |
| $this->assertBrowserCookieValueSame(string $key, string $value) | expect($client)->toHaveClientCookie(string $key, string $value)                |
|                                                                 | expect($client)->toHaveClientCookie(string $key, string $value, strict: false) |

## Assert `Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector`

| Symfony                                                                                              | Pest                                                                                                              |
| ---------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| $this->assertHttpClientRequest(string $url)                                                          | expect($collector)->toHaveHttpClientRequest(string $url)                                                          |
| $this->assertHttpClientRequest(string $url, string $method)                                          | expect($collector)->toHaveHttpClientRequest(string $url, string $method)                                          |
| $this->assertHttpClientRequest(string $url, string $method, mixed $body)                             | expect($collector)->toHaveHttpClientRequest(string $url, string $method, mixed $body)                             |
| $this->assertHttpClientRequest(string $url, string $method, mixed $body, array $headers)             | expect($collector)->toHaveHttpClientRequest(string $url, string $method, mixed $body, array $headers)             |
| $this->assertHttpClientRequest(string $url, string $method, mixed $body, array $headers, string $id) | expect($collector)->toHaveHttpClientRequest(string $url, string $method, mixed $body, array $headers, string $id) |
| $this->assertHttpClientRequestCount(int $count)                                                      | expect($collector)->toHaveHttpClientRequestCount(int $count)                                                      |
| $this->assertHttpClientRequestCount(int $count, string $id)                                          | expect($collector)->toHaveHttpClientRequestCount(int $count, string $id)                                          |

## Assert `Symfony\Component\Mailer\Event\MessageEvents`

| Symfony                                  | Pest                                                                           |
| ---------------------------------------- | ----------------------------------------------------------- |
| $this->assertEmailCount(int $count)      | expect($events)->toHaveEmailCount(int $count)               |
| this->assertQueuedEmailCount(int $count) | expect($events)->toHaveEmailCount(int $count, queued: true) |

## Assert `Symfony\Component\Mailer\Event\MessageEvent`

| Symfony                            | Pest                              |
| ---------------------------------- | --------------------------------- |
| $this->assertEmailIsQueued($event) | expect($event)->toBeEmailQueued() |

## Assert `Symfony\Component\Mime\RawMessage`

| Symfony                                                                 | Pest                                                                            |
| ----------------------------------------------------------------------- | ------------------------------------------------------------------------------- |
| $this->assertEmailAttachmentCount($message, int $count)                 | expect($message)->toHaveEmailAttachmentCount(int $count)                        |
|                                                                         | expect($message)->toHaveEmailTextBody(string $value)                            |
| $this->assertEmailTextBodyContains($message, string $value)             | expect($message)->toHaveEmailTextBody(string $value, strict: false)             |
|                                                                         | expect($message)->toHaveEmailHtmlBody(string $value)                            |
| $this->assertEmailHtmlBodyContains($message, string $value)             | expect($message)->toHaveEmailHtmlBody(string $value, strict: false)             |
| $this->assertEmailHasHeader($message, string $key)                      | expect($message)->toHaveEmailHeader(string $key)                                |
| $this->assertEmailHeaderSame($message, string $key, string $value)      | expect($message)->toHaveEmailHeader(string $key, string $value)                 |
|                                                                         | expect($message)->toHaveEmailHeader(string $key, string $value, strict: false)  |
|                                                                         | expect($message)->toHaveEmailAddress(string $key, string $value)                |
| $this->assertEmailAddressContains($message, string $key, string $value) | expect($message)->toHaveEmailAddress(string $key, string $value, strict: false) |
|                                                                         | expect($message)->toHaveEmailSubject(string $value)                             |
| $this->assertEmailSubjectContains($message, string $value)              | expect($message)->toHaveEmailSubject(string $value, strict: false)              |

## Assert `Symfony\Component\Notifier\Event\NotificationEvents`

| Symfony                                 | Pest                                                               |
| ----------------------------------------| ------------------------------------------------------------------ |
| $this->assertNotificationCount(0)       | expect($events)->toHaveNotificationCount(int $count)               |
| $this->assertQueuedNotificationCount(1) | expect($events)->toHaveNotificationCount(int $count, queued: true) |

## Assert `Symfony\Component\Notifier\Event\MessageEvent`

| Symfony                                   | Pest                                     |
| ----------------------------------------- | ---------------------------------------- |
| $this->assertNotificationIsQueued($event) | expect($event)->toBeNotificationQueued() |

## Assert `Symfony\Component\Notifier\Message\MessageInterface`

| Symfony                                                                 | Pest                                                                      |
| ----------------------------------------------------------------------- | ------------------------------------------------------------------------- |
|                                                                         | expect($message)->toHaveNotificationSubject(string $value)                |
| $this->assertNotificationSubjectContains($message, string $value)       | expect($message)->toHaveNotificationSubject(string $value, strict: false) |
| $this->assertNotificationTransportIsEqual($message, string $value)      | expect($message)->toHaveNotificationTransport(string $value)              |