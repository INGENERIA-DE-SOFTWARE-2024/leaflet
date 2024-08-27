<?php

namespace Model;

class Lugar extends ActiveRecord
{
    protected static $tabla = 'lugar';
    protected static $idTabla = 'lug_id';
    protected static $columnasDB = ['lug_nombre', 'lug_lat', 'lug_lon', 'lug_situacion'];

    public $lug_id;
    public $lug_nombre;
    public $lug_lat;
    public $lug_lon;
    public $lug_situacion;

    public function __construct($args = [])
    {
        $this->lug_id = $args['lug_id'] ?? null;
        $this->lug_nombre = $args['lug_nombre'] ?? '';
        $this->lug_lat = $args['lug_lat'] ?? 0.000000;
        $this->lug_lon = $args['lug_lon'] ?? 0.000000;
        $this->lug_situacion = $args['lug_situacion'] ?? 1;
    }

    public static function obtenerLugaresActivos()
    {
        $sql = "SELECT * FROM " . self::$tabla . " WHERE lug_situacion = 1";
        return self::fetchArray($sql);
    }
}
