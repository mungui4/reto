<?php

class Inventario
{
    private  $listaProductos;
    private $listaVentas = [];
    private $listaUsuarios;

    public function __construct($listaProductos)
    {
        $this->listaProductos = $listaProductos;
    }

    public function agregarProducto(Producto $producto)
    {
        // validar que el dato que me ingresen sea un objeto de PRODUCTO
        $this->listaProductos[] = $producto;
    }

    public function agregarUsuario(Usuario $usuario)
    {
        // validar que el dato que me ingresen sea un objeto de PRODUCTO
        $this->listaUsuarios[] = $usuario;
    }

    public function eliminarProducto($id)
    {
        // Quitar un dato de la lista de PRODUCTOS
        foreach ($this->listaProductos as $key => $producto) {
            if ($producto->getId() == $id) {
                unset($this->listaProductos[$key]);
                return true;
            }
        }
    }

    public function buscarProductoPorCategoria($categoria)
    {
        // Filtrar la lista de productos por la categoria buscada

        return array_filter($this->listaProductos, function ($producto) use ($categoria) {
            return $producto->categoria === $categoria;
        });
    }

    public function generarInforme()
    {
        // Generar informe de productos de X precio
        // Generar informe de productos con stock mas bajo a X numero
        // Generar informe de productos sin stock
        // Generar informe de productos con stock actualizado
    }


    public function agregarVenta(Venta $venta)
    {
        $this->listaVentas[] = $venta;
    }

    public function getListaVentas()
    {
        return $this->listaVentas;
    }

    /**
     * Get the value of listaProductos
     */
    public function getListaProductos()
    {
        return $this->listaProductos;
    }

    public function buscarPorId($id)
    {
        foreach ($this->listaProductos as $producto) {
            if ($producto->getId() == $id) {
                return $producto;
            }
        }
    }

    public function getAll()
    {
        foreach ($this->listaProductos as $producto) {
            echo  $producto->getId() . " -| " . $producto->getNombre() . " | Precio: " . $producto->getPrecio() . " | Cantidad: " . $producto->getStock() . " | Proveedor: " . $producto->getProveedor() . " | Categoria: " . $producto->getCategoria() . " | Descripción: " . $producto->getDescripcion() . "\n";
            echo "--------------------------------------------------------------------------------------------------------------------------\n";
        }
    }

    public function updateProducto($id)
    {
        foreach ($this->listaProductos as  $producto) {
            if ($producto->getId() == $id) {
                $nombre = prompt("\nIngrese el nombre del producto:\n");
                $producto->setNombre($nombre);
                $descripcion = prompt("Ingrese la descripcion del producto:\n");
                $producto->setDescripcion($descripcion);
                $precio = prompt("Ingrese el precio del producto:\n");
                $producto->setPrecio($precio);
                $cantidad = prompt("Ingrese la cantidad del producto:\n");
                $producto->setStock($cantidad);
                $categoria = prompt("Ingrese la categoria de su producto: \n");
                $producto->setCategoria($categoria);
                $proveedor = prompt("Ingrese quien es el proveedor de su producto: \n");
                $producto->setProveedor($proveedor);
                return true;
            }
        }
    }

    public function getListaUsuarios()
    {
        return $this->listaUsuarios;
    }

    /**
     * Set the value of listaUsuarios
     *
     * @return  self
     */
    public function setListaUsuarios($listaUsuarios)
    {
        $this->listaUsuarios = $listaUsuarios;

        return $this;
    }

    public function lessStock($id)
    {
        foreach ($this->listaProductos as $producto) {
            if ($producto->getId() == $id) {
                $stock = $producto->getStock();
                $producto->setStock($stock - 1);
            }
        }
    }

    public function moreStock($id)
    {
        foreach ($this->listaProductos as $producto) {
            if ($producto->getId() == $id) {
                $stock = $producto->getStock();
                $producto->setStock($stock + 1);
            }
        }
    }

    public function seVendio($id)
    {
        foreach ($this->listaProductos as $producto) {
            if ($producto->getId() == $id) {
                $veces = $producto->getVecesVendido();
                $producto->setVecesVendido($veces + 1);
            }
        }
    }

    public function noSeVendio($id)
    {
        foreach ($this->listaProductos as $producto) {
            if ($producto->getId() == $id) {
                $veces = $producto->getVecesVendido();
                $producto->setVecesVendido($veces - 1);
            }
        }
    }

    public function mayorVendido()
    {
        $masVendido = $this->listaProductos[0];
        foreach ($this->listaProductos as $producto) {
            if ($producto->getVecesVendido() > $masVendido->getVecesVendido()) {
                $masVendido = $producto;
            }
        }
        if ($masVendido->getVecesVendido() > 0) {
            echo "\nEl producto más vendido es: " . $masVendido->getNombre();
        } else {
            echo "\nNo se ha vendido ningún producto";
        }
    }

    public function bajoStock()
    {
        $menorStock = $this->listaProductos[0];
        foreach ($this->listaProductos as $producto) {
            if ($producto->getStock() < $menorStock->getStock()) {
                $menorStock = $producto;
            }
        }
        echo "\nEl Producto con menor Stock es: " . $menorStock->getNombre();
    }
}
