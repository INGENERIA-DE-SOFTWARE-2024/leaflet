<?php

namespace Controllers;

use Exception;
use Model\Lugar;
use MVC\Router;

class LugarController 
{
    public static function index(Router $router)
    {
        $lugares = Lugar::find(2);
        $router->render('lugar/index', [
            'lugares' => $lugares
        ]);
    }

    public static function guardarAPI()
    {
        $_POST['lug_nombre'] = htmlspecialchars($_POST['lug_nombre']);
        try {
            $lugar = new Lugar($_POST);
            $resultado = $lugar->crear();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Lugar guardado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar lugar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $lugares = Lugar::obtenerLugaresActivos();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos encontrados',
                'detalle' => '',
                'datos' => $lugares
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al buscar lugares',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        $_POST['lug_nombre'] = htmlspecialchars($_POST['lug_nombre']);
        $id = filter_var($_POST['lug_id'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $lugar = Lugar::find($id);
            $lugar->sincronizar($_POST);
            $lugar->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Lugar modificado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar lugar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        $id = filter_var($_POST['lug_id'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $lugar = Lugar::find($id);
            $lugar->sincronizar([
                'lug_situacion' => 0
            ]);
            $lugar->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Lugar eliminado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar lugar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
