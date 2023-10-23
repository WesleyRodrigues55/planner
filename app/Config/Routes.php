<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

$routes->get('login', 'User::login');
$routes->get('/login/esqueceu-senha', 'User::esqueceuSenha');
$routes->get('/login/cadastro-usuario', 'User::cadastroUser');
$routes->post('/login/forgot', 'User::confirmacaoSenha');

$routes->post('user/verificarlogin', 'User::verificarLogin');
$routes->get('user/logout', 'User::logout');
$routes->get('/administrador/cadastro-produto', 'Administrator::cadastroProduto');
$routes->get('/administrador/lista-produto', 'Administrator::listaProduto');
$routes->get('/administrador/lista-usuario', 'Administrator::listaUsuario');

$routes->get('/depoimentos-clientes', 'Testimony::depoimentosClientes');

$routes->get('/planners', 'Product::planners');
$routes->get('/cadernos', 'Product::cadernos');
$routes->get('/agendas', 'Product::agendas');
$routes->get('/blocos', 'Product::blocos');
$routes->get('/mais-vendidos-semana', 'Product::maisVendidosSemana');
$routes->get('/presentes-criativos', 'Product::presentesCriativos');

$routes->get('/produto/(:any)', 'Product::pagePlanners/$1');
$routes->get('/carrinho', 'BuyCart::carrinho');
$routes->post('carrinho/soma-quantidade', 'BuyCart::somaQuantidade');
$routes->post('carrinho/subtrai-quantidade', 'BuyCart::subtraiQuantidade');


$routes->get('teste', 'User::cookie');
