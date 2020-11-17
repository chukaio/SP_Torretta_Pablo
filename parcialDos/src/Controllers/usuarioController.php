<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;

use App\Modelos\Usuario;

class UsuarioController
{
    //Punto 1
    public function addOne(Request $request, Response $response) 
    {
        $nuevoUsuario = new Usuario;

        $nuevoUsuario->nombre = strtoupper($request->getParsedBody()['nombre']);
        $nuevoUsuario->email = strtoupper($request->getParsedBody()['email']);
        $nuevoUsuario->tipo = strtoupper($request->getParsedBody()['tipo']);
        $nuevoUsuario->clave = strtoupper($request->getParsedBody()['clave']);
        if($nuevoUsuario->save())
        {
            $respuesta = "Usuario guardado en la base de datos correctamente!";
        }        
        $response->getBody()->write(json_encode($respuesta));

        return $response;
    }

    //Punto 2
    public function loginUsuario(Request $request,Response $response)
    {        
        $mail = strtoupper($request->getParsedBody()['email']);
        $clave = strtoupper($request->getParsedBody()['clave']);
        $loginValido = self::verificarUsuario($clave,$mail);
        
        if($loginValido != false)
        {
            $response->getBody()->write(json_encode($loginValido));
        }
        else
        {
            $response->getBody()->write('La clave o el mail no estan registrados en la base de datos!');
        }
        
        return $response;
    }

    //Verificadores
    public static function verificarUsuario($clave,$mail)
    {        
        $usuario = Usuario::where('clave', $clave)->where('email',$mail)->first();
        $payload = array();        
        $encodeCorrecto = false;

        if($usuario != null)
        { 
            $payload = array(
            "mail"=> $mail,
            "clave"=> $clave,
            "legajo"=>$usuario->id,
            "tipo"=>$usuario->tipo
            ); 
            $encodeCorrecto = JWT::encode($payload,'segundo-parcial');
        }
        else
        {
            echo 'Es necesario primero cargar usuarios!';
        }
        
        return $encodeCorrecto;
    }

    public static function PermitirPermisos($token,$tipo)
    {
        $retorno = false;

        try {
            $payload = JWT::decode($token, "segundo-parcial", array('HS256'));
            
            foreach ($payload as $value) {
                if ($value == $tipo) {

                    $retorno = true;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }

        return $retorno;
    }

    public static function ObtenerLegajoToken($token)
    {
        try {
            $payload = JWT::decode($token, "segundo-parcial", array('HS256'));
            foreach ($payload as $key => $value) 
            {
                if ($key == 'legajo') 
                {

                    return $value;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }
    }

    public static function ObtenerTipoToken($token)
    {
        try {
            $payload = JWT::decode($token, "segundo-parcial", array('HS256'));
            foreach ($payload as $key => $value) 
            {
                if ($key == 'tipo') 
                {

                    return $value;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }
    }
}