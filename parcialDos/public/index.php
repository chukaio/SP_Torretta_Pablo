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
$app->setBasePath('/BE/Parcial/SP/parcialDos/public');
new Database;

$app->add(new JsonMiddleware);

$app->post('/users',UsuarioController::class.":addOne");
$app->post('/login',UsuarioController::class.":loginUsuario");


$app->group('/notas',function(RouteCollectorProxy $group){
    $group->put('/{idMateria}',AlumnoMateriaController::class.":asignarNota")->add(new AuthMiddlewareProfesor);
    $group->get('/{idMateria}',AlumnoMateriaController::class.":verNotasMateria")->add(new AuthMiddlewareVarios);
});
$app->group('/materia',function(RouteCollectorProxy $group){
    
    $group->post('[/]',MateriaController::class.":addOne")->add(new AuthMiddlewareAdmin);
    $group->get('[/]',MateriaController::class.":verTodas")->add(new AuthMiddlewareVarios);
});

$app->group('/inscripcion',function(RouteCollectorProxy $group){
    
    $group->post('/{idMateria}',MateriaController::class.":inscripcion")->add(new AuthMiddlewareAlumno);
    $group->get('/{idMateria}',AlumnoMateriaController::class.":inscripcionAlumno")->add(new AuthMiddlewareVarios);
});

$app->addBodyParsingMiddleware();
$app->run();