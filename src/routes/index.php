<?php

	use Slim\Http\Request;
	use Slim\Http\Response;
	include 'users.php';
	include 'categories.php';
	include 'recipes.php';
	// include 'comments.php'; No implemented yet

	$app->group('/api', function() use ($app) {
		$app->get('/[{name}]', function (Request $request, Response $response, array $args) { 
			return $this->renderer->render($response, 'index.phtml', $args);
		});
		// SEGUIDORES COCINEROS
		// Hacer seguidores de cocineros y recetas
	});
