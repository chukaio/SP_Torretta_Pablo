<?php
namespace App\Controllers;

use App\Modelos\Alumno_Materia;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlumnoMateriaController
{
    //Punto 5
    public function asignarNota(Request $request,Response $response,$args)
    {
        $idAlumno = $request->getParsedBody()['idAlumno'];
        $idMateria = $args['idMateria'];
        $respuesta = $idAlumno;

        $response->getBody()->write(json_encode($respuesta));
    }

    public function verTodas(Request $request,Response $response)
    {
        $respuesta = Alumno_Materia::
        join('alumnos', 'alumnos.id', '=', 'alumnos_materias.id_alumno')
        ->join('materias', 'materias.id', '=', 'alumnos_materias.id_materia')
        ->select('alumnos_materias.id_alumno as Alumno', 'alumnos.nombre','materias.materia')
        ->get();            
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }

    //Punto 8
    public function verNotasMateria(Request $request, Response $response,$args)
    {
        $idMateria = $args['idMateria'];
        $respuesta = Alumno_Materia::
        join('materias','materias.id', '=','alumnos_materias.id_materia')
        ->select('alumnos_materias.nota as Notas de la Materia','alumnos_materias.id_materia as Materia','materias.materia as Materia')
        ->where('alumnos_materias.id_materia','=',$idMateria)
        ->get();       
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }

    //Punto 6
    public function inscripcionAlumno(Request $request,Response $response,$args)
    {
        $token = $request->getHeaderLine('token');
        $tipo = UsuarioController::ObtenerTipoToken($token);

        if($tipo == "PROFESOR" || $tipo == "ADMIN")
        {
            $respuesta = Alumno_Materia::
            join('usuarios', 'usuarios.id', '=', 'alumnos_materias.id_alumno')
            ->join('materias', 'materias.id', '=', 'alumnos_materias.id_materia')
            ->select('materias.materia as Incriptos a la Materia','usuarios.nombre as Nombre')
            ->get();            
        }        
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }    
}