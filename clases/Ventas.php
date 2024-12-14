<?php

class Venta
{
        private $idVenta;
        private $listaProductos = [];
        private $total;
        private $usuario;
        //private $listaVentas=[];

        public function __construct($idVenta) //Will
        {
                $this->idVenta = $idVenta;
        }


        function registroVenta($usuario)
        {
                //Registrar una venta con un usario referenciado
                $this->usuario = $usuario;
        }

        function calcularTotal()
        {
                $this->total = 0;
                //Metodo para  calcular total de la venta
                foreach ($this->listaProductos as $producto) {
                        $this->total += $producto->getPrecio();
                }
                return $this->total;
        }

        /**
         * Get the value of listaProductos
         */
        public function getListaProductos()
        {
                return $this->listaProductos;
        }

        /**
         * Set the value of listaProductos
         *
         * @return  self
         */
        public function setListaProductos($listaProductos)
        {
                $this->listaProductos = $listaProductos;

                return $this;
        }

        /**
         * Get the value of total
         */
        public function getTotal()
        {
                return $this->total;
        }

        /**
         * Set the value of total
         *
         * @return  self
         */
        public function setTotal($total)
        {
                $this->total = $total;

                return $this;
        }

        /**
         * Get the value of idVenta
         */
        public function getIdVenta()
        {
                return $this->idVenta;
        }

        public function agregarProducto($producto)
        {
                // validar que el dato que me ingresen sea un objeto de PRODUCTO
                $this->listaProductos[] = $producto;
        }

        public function eliminarProducto($id)
        {
                foreach ($this->listaProductos as $key => $producto) {
                        if ($producto->getId() == $id) {
                                unset($this->listaProductos[$key]);
                                return true;
                        }
                }
        }

        /**
         * Get the value of usuario
         */
        public function getUsuario()
        {
                return $this->usuario;
        }
}
