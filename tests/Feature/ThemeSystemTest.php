<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

test('default theme loads views from resources/views/default', function () {
    Config::set('view.theme', 'default');
    Config::set('view.paths', [
        resource_path('views/default'),
        resource_path('views'),
    ]);

    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee('Investor Login');
});

test('switching theme to modern dynamically renders views from resources/views/modern', function () {
    Config::set('view.theme', 'modern');
    View::prependLocation(resource_path('views/modern'));

    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee('Modern Theme');
});
