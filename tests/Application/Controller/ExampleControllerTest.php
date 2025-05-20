<?php

test('true is true', function () {
    $client = static::createClient();

    $crawler = $client->request('GET', '/example');

    $this->assertResponseIsSuccessful();
});