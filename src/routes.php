<?php

$app->get('/', 'HomeController:home')->setName('home');

$app->group('', function () use ($app) {
    // auth
    $app->get('/auth/signup', 'AuthController:getSignup')->setName('auth.signup');
    $app->post('/auth/signup', 'AuthController:postSignup');
    
    // user signin
    $app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
    $app->post('/auth/signin', 'AuthController:postSignin');
})->add('GestMiddleware')->add('CsrfViewMiddleware')->add('csrf');

// all routes
$app->group('', function () use ($app) {
    // changepassword
    $app->group('', function() use ($app) {
        $app->get('/auth/changepassword', 'PasswordController:getChangePassword')->setName('changepassword');
        $app->post('/auth/changepassword', 'PasswordController:postChangePassword');
    })->add('CsrfViewMiddleware')->add('csrf');
    
    $app->get('/auth/signout', 'AuthController:getSignout')->setName('auth.signout');
    
    // registros controller
    $app->get("/registros[/]", 'RecordController');
    $app->get('/registros/produto', 'RecordController:addProduct');
    $app->get('/registros/tamanho', 'RecordController:addHeight');
    $app->get('/registros/descricao', 'RecordController:desc');
    $app->post('/getH', 'RecordController:getHeightJson');
    $app->post('/addP', 'RecordController:saveProduct');
    $app->get('/getInfo/{id}', 'RecordController:update');
    $app->post('/update[/]', 'RecordController:update');
    
    $app->post('/action', 'RecordController:insert');    
    $app->delete('/action', 'RecordController:remove');
    $app->post('/getReg', 'RecordController:getRegistry');
    $app->get('/getSingleRegistry/{entity}/{id}', 'RecordController:getSingleRegistry');
    
    $app->get('/registros/clientes', 'RecordController:getCustomers');
    $app->put('/registros/clientes', 'RecordController:getSingleRegisterByQuery');
    $app->options('/registros/clientes/{id}', 'RecordController:getSingleRegistry');
    
    //relatorios
    $app->get('/relatorios[/]', 'ReportController')->setName('report');
    $app->get('/relatorios/viagem', 'ReportController:createTravelReport')->setName('travel');
    $app->get('/relatorios/etiqueta', 'ReportController:createTagReport')->setName('tag');
    $app->get('/relatorios/romaneio', 'ReportController:createBoardingDeliveryReport')->setName('boardingDelivery');
    $app->post('/create', 'ReportController:create')->setName('create');

    // produção
    $app->get('/producao[/]', 'ProductionController:index');
    $app->get('/producao/adicionar', 'ProductionController:addProduction');
    
    //redirect to reports
    $app->get('/producao/relatorios', function ($request, $response) {
        return $response->withRedirect('/relatorios');
    });

    $app->post('/getProductJson', 'ProductionController:getProductJson');
    $app->post('/sendProduction', 'ProductionController:saveProduction');
    
    
});//->add('AuthMiddleware');

