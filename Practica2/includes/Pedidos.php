<?php

class Pedidos extends Usuario
{
    use MagicProperties;

    private $estado;
    private $lista = array();   //Temporal

    public function anyadirProducto($producto){
        array_push($lista, $producto->nombre);
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
            $producto->unidades-1,
            $producto->id_producto
        );
    }
    

    public function eliminarProducto($producto){
        if(in_array($producto->nombre, $lista)){
            unset($lista[1]);   //solo funciona en arrays asociativos
            $result = false;
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf("UPDATE Productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
                $producto->unidades+1,
                $producto->id_producto
            );
        }
    }

    public function procesarPedido(){   //Se podra usar para modificar el estado del pedido

    }
    
}