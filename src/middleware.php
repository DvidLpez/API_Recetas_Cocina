<?php
// Application middleware
// $app->add(new \Slim\Csrf\Guard);

// Middleware autenticación por token JWT
$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "path" => ["/v1"], /* or ["/api", "/admin"] */
    // "attribute" => "decoded_token_data", /* Mostrar attribute in view */
    "secret" => $app->getContainer()->get('settings')['jwt']['secret'],
    "algorithm" => $app->getContainer()->get('settings')['jwt']['algorithm'],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));
