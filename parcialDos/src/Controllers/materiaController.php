<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Modelos\Materia;
use App\Modelos\Alumno_Materia;
use App\Modelos\Usuario;

class MateriaController
{
    //Punto 3
    public function addOne(Request $request, Response $response) 
    {
        $respuesta = "Se ha producido un error al guardar o el permiso es invalido";        
        $nuevaMateria = new Materia;        
        $nuevaMateria->materia = $request->getParsedBody()['materia'];
        $nuevaMateria->cuatrimestre = $request->getParsedBody()['cuatrimestre'];
        $nuevaMateria->cupos = $request->getParsedBody()['cupos'];

        if($nuevaMateria->save())
        {
            $respuesta = "Materia guardada en la base de datos correctamente!";
        }        
        $response->getBody()->write(json_encode($respuesta));

        return $response;
    }
    
    //Punto 4
    public function inscripcion(Request $request, Response $response,$args)
    {        
        $respuesta = "Se ha producido un error al inscribir o el alumno es incorrecto";
        $idAlumno = UsuarioController::ObtenerLegajoToken($request->getHeaderLine('token'));
        $idMateria = $args['idMateria'];
        $nuevaInscripcion = new Alumno_Materia;

        if($this->traerMaterias($idMateria))
        {            
            $nuevaInscripcion->id_alumno = $idAlumno;
            $nuevaInscripcion->id_materia = $idMateria;
            $nuevaInscripcion->save();            
            $respuesta = "La inscripcion se ha realizado correctamente!";
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

    //Punto 7
    public function verTodas(Request $request, Response $response)
    {
        $respuesta = Materia::get();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}