<?php

it('returns a successful response with the updated important notice', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSeeText('We are forced to increase our online prices due to increased cost of Blue Dart courier. We have not');
    $response->assertSeeText('increased our product prices. But we are despatching through Blue Dart courier because of their dependability.');
});
