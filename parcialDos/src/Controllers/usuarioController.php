<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;

use App\Modelos\Usuario;

class UsuarioController
{
    public function addOne(Request $request, Response $response) 
    {
        $nuevoUsuario = new Usuario;

        $nuevoUsuario->nombre = strtoupper($request->getParsedBody()['nombre']);
        $nuevoUsuario->email = strtoupper($request->getParsedBody()['email']);
        $nuevoUsuario->tipo = strtoupper($request->getParsedBody()['tipo']);
        $nuevoUsuario->clave = strtoupper($request->getParsedBody()['clave']);

        if($nuevoUsuario->save())
        {
            $respuesta = "Guardado en la base de datos correcto";
        }
        

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

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
            $response->getBody()->write('Clave o mail no registrados');
        }
        
        return $response;
    }


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
            echo 'Primero debe cargar usuarios';
        }
        
        return $encodeCorrecto;
    }

    //VERIFICA PERMISOS
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

    //OBTENER EL LEGAJO
    public static function ObtenerLegajoToken($token)
    {
        //$retorno = false;
        try {
            $payload = JWT::decode($token, "segundo-parcial", array('HS256'));
            //var_dump($payload);
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
        //return $retorno;
    }


    //OBTENER TIPO
    public static function ObtenerTipoToken($token)
    {
        //$retorno = false;
        try {
            $payload = JWT::decode($token, "segundo-parcial", array('HS256'));
            //var_dump($payload);
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
        //return $retorno;
    }
}