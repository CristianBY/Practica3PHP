<!DOCTYPE html>
<html>
<head>
	<title>Listado</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
	<div class="cabecera">
		<h1>Tarea: Listado de productos de una familia</h1>
		<form action="listado.php" method="POST">
			Familia:&nbsp;<select name="select">
			<?php //Creamos conexión y cargamos el select.
				try{ //Probamos conexión
					$mbd = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'Aabc123.',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					$sentencia = $mbd->prepare("SELECT * FROM familia");
					$sentencia->execute();
					while ($fila = $sentencia->fetch()) { //Se carga el select para que muestre los nombres de las familias 
						if ($_POST['ocultoCancelado']==$fila[0]){ // Para devolver otra vez la lista con la selección de la última familia por si se cancela o se introduce mal un dato.
							print("<option value='".$fila[0]."' selected>".$fila[1]."</option>");
						} else { //Carga de select para el inicio de ejecución o cuando la actualización se ha producido
							print("<option value=".$fila[0].">".$fila[1]."</option>");
						}

					}
				} catch (Exception $e) { //Para controlar errores de conexión
					die("Unable to connect: " . $e->getMessage());
				}

			?>
			</select>
			<input type="submit" name="enviar" value="Mostrar productos">
		</form>
	</div>
	<div class="contenido">
	<?php
		if(isset($_POST['enviar'])){ //Devuelve los productos de la familia seleccionada.
			print("<h1>Productos de la familia</h1>");
			$sentencia2 = $mbd->prepare("SELECT * FROM producto WHERE familia = ?");
			$sentencia2->bindParam(1,$_POST['select']);
			$sentencia2->execute();
			
			while ($fila = $sentencia2->fetch()) { //Se crea un formulario para cada producto de la familia para despues ser enviado a editar.php
				print("<form action='editar.php' method='POST'>");
				print("Nombre: ".$fila[2]." ".$fila[4]."€ <input type='submit' name='editar' value='Editar'><br/><input type='hidden' name='ocultoEdita' value='".$fila[0]."'><br/></form>");
			}
			$mbd = null;
		} elseif(!empty($_POST['ocultoCancelado'])) { //Para mostrar otra vez los artículos de la familia seleccionada cuando hemos cancelado una actualización o hemos introducido datos erroneos que no han podido actualizar la base de datos.
			print("<h1>Productos de la familia</h1>");
			$sentencia2 = $mbd->prepare("SELECT * FROM producto WHERE familia = ?");
			$sentencia2->bindParam(1,$_POST['ocultoCancelado']);
			$sentencia2->execute();
			
			while ($fila = $sentencia2->fetch()) { //Se crea un formulario para cada producto de la familia para despues ser enviado a editar.php
				print("<form action='editar.php' method='POST'>");
				print("Nombre: ".$fila[2]." ".$fila[4]."€ <input type='submit' name='editar' value='Editar'><br/><input type='hidden' name='ocultoEdita' value='".$fila[0]."'><br/></form>");
			}
			$mbd = null;
		}
	?>
	</div>	
	
</body>
</html>