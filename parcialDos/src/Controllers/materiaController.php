<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use \Firebase\JWT\JWT;


use App\Modelos\Materia;
use App\Modelos\Alumno_Materia;
use App\Modelos\Usuario;

class MateriaController
{
    public function addOne(Request $request, Response $response) 
    {
        $respuesta = "Error al guardar o permiso invalido";
        
        $nuevaMateria = new Materia;
        
        $nuevaMateria->materia = $request->getParsedBody()['materia'];
        $nuevaMateria->cuatrimestre = $request->getParsedBody()['cuatrimestre'];
        $nuevaMateria->cupos = $request->getParsedBody()['cupos'];

        if($nuevaMateria->save())
        {
            $respuesta = "Guardado en la base de datos correcto";
        }
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function inscripcion(Request $request, Response $response,$args)
    {
        
        $respuesta = "No se pudo inscribir o no es un alumno";
        $idAlumno = UsuarioController::ObtenerLegajoToken($request->getHeaderLine('token'));
        $idMateria = $args['idMateria'];

        $nuevaInscripcion = new Alumno_Materia;
        if($this->traerMaterias($idMateria))
        {
            
            $nuevaInscripcion->id_alumno = $idAlumno;
            $nuevaInscripcion->id_materia = $idMateria;
            $nuevaInscripcion->save();
            
            $respuesta = "Inscripcion correcta";
        }
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function traerMaterias($idMateria)
    {
        $hayCupo = false;
        $listaMaterias = Materia::get();
        foreach ($listaMaterias as $materia) 
        {
            if($materia->cupos > 0 && $idMateria == $materia->id)
            {
                $materia->cupos --;
                $materia->save();
                $hayCupo =  true;
            }
        }
        return $hayCupo;
    }

    public function verTodas(Request $request, Response $response)
    {
        $respuesta = Materia::get();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}