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
				$mbd = mysqli_connect('localhost','dwes','Aabc123.','dwes');
				mysqli_set_charset($mbd,'utf8');
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				$sql= "SELECT cod,nombre FROM familia";
				$sentencia = mysqli_query($mbd,$sql);
				while ($fila = mysqli_fetch_assoc($sentencia)) { //Se carga el select para que muestre los nombres de las familias 
					if ($_POST['ocultoCancelado']==$fila['cod']){ // Para devolver otra vez la lista con la selección de la última familia por si se cancela o se introduce mal un dato.
						print("<option value='".$fila['cod']."' selected>".$fila['nombre']."</option>");
					} else { //Carga de select para el inicio de ejecución o cuando la actualización se ha producido
						print("<option value=".$fila['cod'].">".$fila['nombre']."</option>");
					}
				}
				mysqli_free_result($sentencia);
				mysqli_close($sentencia);
				mysqli_close($mbd);
			?>
			</select>
			<input type="submit" name="enviar" value="Mostrar productos">
		</form>
	</div>
	<div class="contenido">
	<?php
		if(isset($_POST['enviar'])){ //Devuelve los productos de la familia seleccionada.
			print("<h1>Productos de la familia</h1>");
			$mbd = mysqli_connect('localhost','dwes','Aabc123.','dwes');
			mysqli_set_charset($mbd,'utf8');
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$sentencia2=mysqli_prepare($mbd,"SELECT cod,nombre_corto,PVP FROM producto WHERE familia =?");
			mysqli_stmt_bind_param($sentencia2,'s',$_POST['select']);
			mysqli_stmt_execute($sentencia2);
			$resultado = mysqli_stmt_get_result($sentencia2);
			while ($fila = mysqli_fetch_assoc($resultado)) { //Se crea un formulario para cada producto de la familia para despues ser enviado a editar.php
				print("<form action='editar.php' method='POST'>");
				print("Nombre: ".$fila['nombre_corto']." ".$fila['PVP']."€ <input type='submit' name='editar' value='Editar'><br/><input type='hidden' name='ocultoEdita' value='".$fila['cod']."'><br/></form>");
			}
			
			mysqli_free_result($sentencia2);
			mysqli_close($sentencia2);
			mysqli_close($mbd);
		} elseif(!empty($_POST['ocultoCancelado'])) { //Para mostrar otra vez los artículos de la familia seleccionada cuando hemos cancelado una actualización o hemos introducido datos erroneos que no han podido actualizar la base de datos.
			print("<h1>Productos de la familia</h1>");
			$mbd = mysqli_connect('localhost','dwes','Aabc123.','dwes');
			mysqli_set_charset($mbd,'utf8');
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$sentencia2 = mysqli_prepare($mbd,"SELECT * FROM producto WHERE familia = ?");
			mysqli_stmt_bind_param($sentencia2,"s",$_POST['ocultoCancelado']);
			mysqli_stmt_execute($sentencia2);
			$resultado = mysqli_stmt_get_result($sentencia2);
			while ($fila = mysqli_fetch_assoc($resultado)) { //Se crea un formulario para cada producto de la familia para despues ser enviado a editar.php
				print("<form action='editar.php' method='POST'>");
				print("Nombre: ".$fila['nombre_corto']." ".$fila['PVP']."€ <input type='submit' name='editar' value='Editar'><br/><input type='hidden' name='ocultoEdita' value='".$fila['cod']."'><br/></form>");
			}
			mysqli_free_result($sentencia2);
			mysqli_close($sentencia2);
			mysqli_close($mbd);
		}
	?>
	</div>	
	
</body>
</html>