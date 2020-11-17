<?php
/*use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;*/
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;
use Config\Database;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddlewareAdmin;
use App\Middlewares\AuthMiddlewareAlumno;
use App\Middlewares\AuthMiddlewareProfesor;
use App\Middlewares\AuthMiddlewareVarios;
//use App\Controllers\AlumnoController;
use App\Controllers\UsuarioController;
use App\Controllers\MateriaController;
//use App\Modelos\Alumnos_Materias;
use App\Controllers\AlumnoMateriaController;
use App\Modelos\Alumno;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('BE/Parcial/SP_Torretta_Pablo/parcialDos/public'); 
//$app->addBodyParsingMiddleware();
new Database;
$app->add(new JsonMiddleware);

//Punto 1
$app->post('/users',UsuarioController::class.":addOne");

//Punto 2
$app->post('/login',UsuarioController::class.":loginUsuario");

//Punto 5 y 
$app->group('/notas',function(RouteCollectorProxy $group){
    //Punto 5
    $group->put('/{idMateria}',AlumnoMateriaController::class.":asignarNota")->add(new AuthMiddlewareProfesor);
    $group->get('/{idMateria}',AlumnoMateriaController::class.":verNotasMateria")->add(new AuthMiddlewareVarios);
});

//Punto 3 y 7
$app->group('/materia',function(RouteCollectorProxy $group){
    //Punto 3
    $group->post('[/]',MateriaController::class.":addOne")->add(new AuthMiddlewareAdmin);
    //Punto 7
    $group->get('[/]',MateriaController::class.":verTodas")->add(new AuthMiddlewareVarios);
});

//Punto 4 y 6
$app->group('/inscripcion',function(RouteCollectorProxy $group){
    //Punto 4
    $group->post('/{idMateria}',MateriaController::class.":inscripcion")->add(new AuthMiddlewareAlumno);
    //Punto 6
    $group->get('/{idMateria}',AlumnoMateriaController::class.":inscripcionAlumno")->add(new AuthMiddlewareVarios);
});

$app->addBodyParsingMiddleware();
$app->run();