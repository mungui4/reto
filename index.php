<?php

require_once './clases/Producto.php';
require_once './clases/Inventario.php';
require_once './clases/Ventas.php';
require_once './clases/Usuario.php';
require_once './clases/Empleado.php';

function displayMenu()
{
    echo "\n\n\n---- Menu de la Tiendita ---- \n";
    echo "1. Agregar nuevo producto \n";
    echo "2. Eliminar producto \n";
    echo "3. Actualizar producto \n";
    echo "4. Generar Venta \n";
    echo "5. Generar Informe \n";
    echo "6. Salir \n";
    echo "Seleccione una opcion: ";
}

function prompt($mensaje)
{
    echo $mensaje;
    $input = trim(fgets(STDIN));
    return $input;
}
$producto1 = new Producto(1, "Manzana", "Fruta fresca", 0.50, 100, "Fruteria", "Frutas");
$producto2 = new Producto(2, "Pan", "Pan integral", 1.20, 50, "Panaderia", "Panadería");
$producto3 = new Producto(3, "Leche", "Leche descremada", 1.50, 30, "Lacteos José", "Lácteos");

$inventario = new Inventario([$producto1, $producto2, $producto3]);

$flag = true;
$idProducto = 0;
$idVenta = 0;
echo "Ingrese sus datos para continuar\n";
$nombre = prompt("nombre: ");
$id = prompt("Id: ");
$rol = prompt("Rol: ");
$password = prompt("Password: ");

$usuario = new Empleado($id, $nombre, $rol, $password);

$inventario->agregarUsuario($usuario);

foreach ($inventario->getListaUsuarios() as $usuario) {
    echo "\n------|Bienvenido " . $usuario->getNombre() . "|------";
}

while ($flag) {
    displayMenu();
    $opcion = prompt("");
    switch ($opcion) {
        case 1:
            //Obtenemos valores de producto a traves del uso de prompt (funcion para obtener valores de la terminal)
            $idProducto = count($inventario->getListaProductos()) + 1;
            $nombre = prompt("\nIngrese el nombre del producto:\n");
            $descripcion = prompt("Ingrese la descripcion del producto:\n");
            $precio = prompt("Ingrese el precio del producto:\n");
            $cantidad = prompt("Ingrese la cantidad del producto:\n");
            $categoria = prompt("Ingrese la categoria de su producto: \n");
            $proveedor = prompt("Ingrese quien es el proveedor de su producto: \n");
            //Creamos nuevo producto con los valores recibidos por prompt
            $producto = new Producto($idProducto, $nombre, $descripcion, $precio, $cantidad, $proveedor, $categoria);


            //Agregamos el nuevo producto a nuestro inventario
            $inventario->agregarProducto($producto);
            echo "Ingresado con éxito \n";
            break;
        case 2:
            echo "\n----Productos disponibles---- \n";
            echo $inventario->getAll();
            $opcion = prompt("\n\nIngrese el número del producto a ELIMINAR:");
            $resultado =  $inventario->eliminarProducto($opcion);
            if ($resultado) {
                echo "\nEliminado con éxito";
            } else {
                echo "\nError al Eliminar";
            }
            break;
        case 3:
            echo "\n----Productos disponibles---- \n";
            echo $inventario->getAll();
            $opcion = prompt("\n\nIngrese el número del producto a ACTUALIZAR:");
            $resultado = $inventario->updateProducto($opcion);
            if ($resultado) {
                echo "\nActualizado con éxito";
            } else {
                echo "\nError al actualizar";
            }
            break;
        case 4:
            echo "--------Estas generando una nueva venta--------\n";
            $idVenta = $idVenta + 1;
            $venta = new Venta($idVenta);
            $venta->registroVenta($usuario);

            $flag2 = true;
            while ($flag2) {


                echo "\n\n\n---- Factura número " . $venta->getIdVenta() . "----";
                echo "\nProductos en esta factura:";
                foreach ($venta->getListaProductos() as $producto) {
                    echo "\n" . $producto->getNombre();
                }
                echo "\n----------------------------";
                echo "\nTotal de esta factura: ";
                $venta->calcularTotal();
                echo $venta->getTotal();
                echo "\n----------------------------";
                echo "\n1. Agregar nuevo producto \n";
                echo "2. Eliminar un producto \n";
                echo "3. Guardar y salir\n";
                echo "Seleccione una opcion: ";
                $opcion = prompt("");
                switch ($opcion) {
                    case 1:
                        echo "\n ----Productos disponibles----\n";
                        foreach ($inventario->getListaProductos() as $producto) {
                            echo "\n" . $producto->getId() . "-: " . $producto->getNombre() . "- Cantidad disponible: " . $producto->getStock();
                        }
                        echo "\nIngrese el número del producto a agregar en la venta:";
                        $opcion = prompt("");
                        $producto = $inventario->buscarPorId($opcion);
                        $venta->agregarProducto($producto);
                        $inventario->lessStock($opcion);
                        $inventario->seVendio($opcion);

                        break;

                        break;
                    case 2:
                        foreach ($venta->getListaProductos() as $producto) {
                            echo "\n" . $producto->getId() . "-" . $producto->getNombre();
                        };

                        $opcion = prompt("\n\nIngrese el número del producto a eliminar:");
                        $venta->eliminarProducto($opcion);
                        $inventario->moreStock($opcion);
                        $inventario->noSeVendio($opcion);
                        break;
                    case 3:
                        $flag2 = false;
                        $inventario->agregarVenta($venta);
                        break;
                    default:
                        echo "Seleccione una opción válida \n";
                }
            }


            break;
        case 5:
            echo "\n--------Estas generando un informe--------\n";
            $mayorVendido = $inventario->mayorVendido();
            $menorStock = $inventario->bajoStock();
            break;
        case 6:
            echo "Estas saliendo ... \n";
            $flag = false;
            break;

        default:
            echo "Seleccione una opcion valida \n";
    }
}
