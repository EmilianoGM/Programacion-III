<?php
interface IParte2{
    public function Agregar();
    public static function Traer();
    public function CalcularIVA();
    public function Existe();
    public function Modificar($idABuscar);
    public function Eliminar();
}
?>