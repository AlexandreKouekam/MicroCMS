<?php


// Home page

$app->get('/', function () use ($app) {

    $users = $app['dao.user']->findAll();

    ob_start();             // start buffering HTML output
    require '../views/view.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;

});

$app->get('/api/token/verif', function($token) use ($app) {
    $url = 'http://domain.com/get-post.php';
    $fields = array(
        'token' => $token,
    );

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields['token']);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);

    // Create and return a JSON response
    return $app->json($result);
})->bind('api_users');



$app->get('/api/token/create', function() use ($app) {
    $url = 'http://domain.com/get-post.php';
    $ch = curl_init();


    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false);

    $output = curl_exec($ch);

    curl_close($ch);

    // Create and return a JSON response
    return $app->json($output);
})->bind('api_users');
