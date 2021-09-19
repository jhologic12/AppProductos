
<?php




/*-----------------Inicia BLOQUE de Codigo para capturar datos de Productos----------------------------------------*/

/* capturamos los valores obtenidos en el formulario Categoria y lo guardamos en dos variables */
$txtcodig=(isset($_POST['txtcodig']))?$_POST['txtcodig']:"";
$txtnombre=(isset($_POST['txtnombre']))?$_POST['txtnombre']:"";
$txtdescripcion=(isset($_POST['txtdescripcion']))?$_POST['txtdescripcion']:"";
$txtdisponible=(isset($_POST['txtdisponible']))?$_POST['txtdisponible']:"";
$txtcategoria=(isset($_POST['txtcategoria']))?$_POST['txtcategoria']:"";
$txtprecio=(isset($_POST['txtprecio']))?$_POST['txtprecio']:"";
$txtfoto=(isset($_FILES['txtfoto']["name"]))?$_FILES['txtfoto']:"";
$ejecutar= (isset($_POST['ejecutar']))?$_POST['ejecutar']:"";

/*----------------------------------Finaliza captura de formulario Productos -------------------------------------------*/


    




/*-----------------Inicia BLOQUE de Codigo para capturar datos de Categoria----------------------------------------*/
/* capturamos los valores obtenidos en el formulario Categoria y lo guardamos en dos variables */
$txtCodigo=(isset($_POST['txtCodigo']))?$_POST['txtCodigo']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$accion= (isset($_POST['accion']))?$_POST['accion']:"";


/*----------------------------------Finaliza captura de formulario Categoria -------------------------------------------*/









/* Realizamos la conexión a la base de Datos. */
include("conexion/conexion.php");




switch($ejecutar) {

    

    case "btnAgregarP":
             

        /*Crear un objeto a partir de la instancia $pdo  y asignamos a un objeto cadena */

        
            $cade=$pdo->prepare("INSERT INTO productos(codigo,nombre,descripcion,categoria,disponible,precio,imagen) VALUES (:codigo,:nombre,:descripcion,:categoria,:disponible,:precio,:imagen) ");
                    /*Pasamos los valores que tenemos almacenados en las variables temporales*/
                    
                    $cade->bindParam(':codigo',$txtcodig);
                     $cade->bindParam(':nombre',$txtnombre);
                     $cade->bindParam(':descripcion',$txtdescripcion);
                    $cade->bindParam(':categoria',$txtdisponible);
                     $cade->bindParam(':disponible',$txtcategoria);
                     $cade->bindParam(':precio',$txtprecio);

                   /*Instruccion para controlar conflicto por imagenes con nombre iguales */
                    $Fecha = new DateTime(); /*Define una variable de tipo tiempo */

                    $nombreArchivo=($txtfoto!="")?$Fecha->getTimestamp()."_".$_FILES["txtfoto"]["name"]:"imagen.jpg";

                    $tmpImagen= $_FILES["txtfoto"]["tmp_name"];

                    /*Condicion pae evaluar si la variable es diferente, en caso afirmativo se asigna con un nuevo nombre */
                    if($tmpImagen!=""){
                        move_uploaded_file ($tmpImagen,"imagenes/".$nombreArchivo);
                    }




                     $cade->bindParam(':imagen',$nombreArchivo);


                     $cade->execute();
          
                     break;  

        



     }   
         








/* Evaluamos el boton que presiono el usuario */




switch($accion) {
    

    
    case "btnAgregar":

       $Mcate ="display:none";
    

             /*Crear un objeto a partir de la instancia $pdo  y asignamos a un objeto cadena */
            $cadena=$pdo->prepare("INSERT INTO categoria(codigo,nombre) VALUES (:codigo,:nombre) ");

            /*Pasamos los valores que tenemos almacenados en las variables temporales*/

            $cadena->bindParam(':codigo',$txtCodigo);
            $cadena->bindParam(':nombre',$txtNombre);

            $cadena->execute();



        break;
     case "btnModificar":
        echo "Presionaste boton Modificar";
        echo $txtCodigo;
        echo $txtNombre;
         break;

    case "btnEliminar":
        echo "Presionaste boton Eliminar";
        echo $txtCodigo;
        echo $txtNombre;

            break;

     case "btnCancelar":
        echo "Presionaste boton Cancelar";
        echo $txtCodigo;
        echo $txtNombre;
            break;


    

        } 
           


/*Definimos instruccion sql para mostrar datos de la tabla categoria */

$cnsltCtgria= $pdo->prepare( "SELECT * FROM `categoria` WHERE 1");

$cnsltCtgria->execute();

$listaCtgria=$cnsltCtgria->fetchALL(PDO::FETCH_ASSOC);




/*Definimos instruccion sql para mostrar datos de la tabla Productos */

$cnsltProduct= $pdo->prepare( "SELECT * FROM `productos` WHERE 1");

$cnsltProduct->execute();

$listaProduct=$cnsltProduct->fetchALL(PDO::FETCH_ASSOC);


                    
/*


*/








?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel ="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>


     
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/poppers.js/1.12.9/udm/popper.min.js" > </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"> </script>




    
    <title>Ingreso Categoria de Productos</title>
</head>
<body>
    

 <!-- -------------------------------------------Modal  Registro de Categoria--------------------------------------------------------------->

 <div class="container">
 <form action="" method="post" ectype="multipart/form-data"> 
   

   
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">

        <div class="form-row">

            <label for="">Codigo</label>
            <input class="form-control" type="text" name="txtCodigo" placeholder="" id="txtCodigo" require="" autocomplete="off">
            <br>
            <label for="">Nombre:</label>
            <input class="form-control" type="text" name="txtNombre" placeholder="" id="txtCodigo" require="" autocomplete="off">
            <br>

        </div>
      </div>
      <div class="modal-footer">

        <button value="btnAgregar"  class="btn btn-success " type="submit" name="accion"> Agregar </button>
        <button value="btnModificar" class="btn btn-warning " type="submit" name="accion"> Modificar </button>
        <button value="btnEliminar" class="btn btn-danger " type="submit" name="accion"> Eliminar </button>
        <button value="btnCancelar" class="btn btn-primary " type="submit" name="accion"> Cancelar </button>

       
      </div>
    </div>
  </div>
</div>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Agregar Categoria + 
</button>

       </form> 








<!--------------------------------------- --------------------Modal  Registro de Producto------------------------------------------->


<div class="container">
    <form action="" method="post" enctype="multipart/form-data"> 
   

    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">

        <div class="form-row">

       

        <label for="">Codigo</label>
            <input class="form-control" type="text" name="txtcodig" placeholder="" id="txtcodig" require="" autocomplete="off">
            <br>
            <label for="">Nombre:</label>
            <input class="form-control" type="text" name="txtnombre" placeholder="" id="txtnombre" require="" autocomplete="off">
            <br>

            <label for="">Descripcion:</label>
                <br>
            <input class="form-control" type="text" name="txtdescripcion" placeholder="" id="txtdescripcion" require="" autocomplete="off">

            <br>
            

            
                 <select class="form-control" name="txtdisponible" id="txtdisponible"  aria-label="Default select example" required="" >
                     <br>
                             <option selected>Disponible</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                            
                    </select>

             <br>
             <br>

                <select class="form-control" name="txtcategoria" id="txtcategoria"  aria-label="Default select example" required="">
                    <br>
                        <option selected="">Categoria:</option>
                    <?php
                    foreach ($listaCtgria as $valores):
                    echo '<option value="'.$valores["nombre"].'">'.$valores["nombre"].'</option>';
                    endforeach;
                    
                    ?>
                </select>
                <br>

    


            <label for="">Precio:</label>
            
            <input class="form-control" type="text" name="txtprecio" placeholder="" id="txtprecio" require="" autocomplete="off">
            <br>


            <label for="">Foto:</label>
            <input class="form-control" type="file" accept="imge/*" name="txtfoto" placeholder="" id="txtfoto" require="" autocomplete="off">
            <br>


          </div>

        
      </div>


      <div class="modal-footer">

        <button value="btnAgregarP"  class="btn btn-success" type="submit" name="ejecutar"> Agregar </button>
         <button value="btnModificarP" class="btn btn-warning" type="submit" name="ejecutar"> Modificar </button>
        <button value="btnEliminarP" class="btn btn-danger" type="submit" name="ejecutar"> Eliminar </button>
        <button value="btnCancelarP" class="btn btn-primary" type="submit" name="ejecutar"> Cancelar </button>




            
        </div>
      </div>
      
    </div>
  </div>
</div>

     <!-- Button trigger modal -->
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
        Agregar Productos + 
        </button>

     </form> 

     

    
        <div class="row"> <br> <br>      </div>

        

    
           
 
    

        <!-- tabla que me permite mostrar el contenido de la tabla Categoria Inicio de bloque -->
       <div class="row">

                <table class="table" name="mostrarTabla"  value="MostrarC" style="display:block">
                    <thead class ="thead-dark"> 
                        <tr>
                            <th scope="col">Codigo Producto</th>
                            <th scope="col">Nombre Producto</th>
                        </tr>
                    </thead>

                    <?php foreach ($listaCtgria as $listaC){ ?>
                        <tr>
                            <td> <?php echo $listaC['codigo']; ?> </td>
                            <td> <?php echo $listaC['nombre']; ?> </td>


                        </tr>

                    <?php } ?>


                </table>



        </div>


<!-- tabla que me permite mostrar el contenido de la tabla Categoria Fin de bloque -->
        


 <!-- tabla que permite mostrar los datos que se van ingresando en la tabla Productos-->




 <div class="container">
    

    <!-- tabla que me permite mostrar el contenido de la tabla Categoria Inicio de bloque -->
   <div class="row">

            <table class="table" name="mostrarTabla"  value="MostrarP"style="display:block" >
                <thead class ="thead-dark"> 
                    <tr>
                        <th scope="col">Codigo Producto</th>
                        <th scope="col">Nombre Producto</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Imagen</th>

                    </tr>
                </thead>

                <?php foreach ($listaProduct as $listaP){ ?>
                    <tr>
                        <td> <?php echo $listaP['codigo']; ?> </td>
                        <td> <?php echo $listaP['nombre']; ?> </td>
                        <td> <?php echo $listaP['descripcion']; ?> </td>
                        <td> <?php echo $listaP['categoria']; ?> </td>
                        <td> <?php echo $listaP['disponible']; ?> </td>
                        <td> <?php echo $listaP['precio']; ?> </td>
                        <td><img class="img-thumbnail" width="100px"src="Imagenes/<?php echo $listaP['imagen']; ?>"/>  </td>


                    </tr>

                <?php } ?>


            </table>



    </div>





















        
</div>


</body>
</html>