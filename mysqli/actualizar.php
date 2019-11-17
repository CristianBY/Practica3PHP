<!DOCTYPE html>
<html>
<head>
	<title>Actualizar</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
	<form action="listado.php" method="POST">
		<?php
			// if else para controlar errores de escritura en la base de datos en los casos de no actualización imprime el producto en un formulario que no se puede esditar e indica el apartado o apartados que ha introducido erróneamente.
			if (isset($_POST['actualizar']) && (!empty($_POST['nombrecorto'])) && (!empty($_POST['pvp']))){ //Si cumple inicia la actualización.
				print("Se han actualizado los datos<br/>");
				$mbd = mysqli_connect('localhost','dwes','Aabc123.','dwes');
				mysqli_set_charset($mbd,'utf8');
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				$sql="UPDATE producto SET nombre = '".$_POST['nombre']."',nombre_corto = '".$_POST['nombrecorto']."',descripcion = '".$_POST['descripcion']."',PVP = '".$_POST['pvp']."' WHERE cod = '".$_POST['ocultoCodigo']."'";
				mysqli_query($mbd,$sql);
			}elseif (empty($_POST['nombrecorto']) && empty($_POST['pvp'])) { // No actualiza, he indica que nombre_corto y PVP no se han escrito
				print("<h1>Producto:</h1>");
				print("Nombre corto:<input type='text' name='nombrecorto' value='".$_POST['nombrecorto']."' disabled><span>No se han actualizado los datos inserte Nombre corto</span><br/>");
				print("Nombre:</br>");
				print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$_POST['nombre']."' disabled>".$_POST['nombre']."</textarea><br/>");
				print("Descripción:<br/>");
				print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$_POST['descripcion']."' disabled>".$_POST['descripcion']."</textarea><br/>");
				print("PVP:<input type='text' name='pvp' value='".$_POST['pvp']."' disabled><span>No se han actualizado los datos inserte un pvp</span><br/>");
				?>
				<input type="hidden" name="ocultoCancelado" value="<?php echo $_POST['ocultoActualiza'];?>">
				<?php
			}elseif (empty($_POST['nombrecorto'])) { // No actualiza, he indica que nombre_corto no se ha escrito
				print("<h1>Producto:</h1>");
				print("Nombre corto:<input type='text' name='nombrecorto' value='".$_POST['nombrecorto']."' disabled><span>No se han actualizado los datos inserte Nombre corto</span><br/>");
				print("Nombre:</br>");
				print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$_POST['nombre']."' disabled>".$_POST['nombre']."</textarea><br/>");
				print("Descripción:<br/>");
				print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$_POST['descripcion']."' disabled>".$_POST['descripcion']."</textarea><br/>");
				print("PVP:<input type='text' name='pvp' value='".$_POST['pvp']."' disabled><br/>");
				?>
				<input type="hidden" name="ocultoCancelado" value="<?php echo $_POST['ocultoActualiza'];?>">
				<?php
			}elseif (empty($_POST['pvp'])) { // No actualiza, he indica que PVP no se ha escrito
				print("<h1>Producto:</h1>");
				print("Nombre corto:<input type='text' name='nombrecorto' value='".$_POST['nombrecorto']."' disabled><br/>");
				print("Nombre:</br>");
				print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$_POST['nombre']."' disabled>".$_POST['nombre']."</textarea><br/>");
				print("Descripción:<br/>");
				print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$_POST['descripcion']."' disabled>".$_POST['descripcion']."</textarea><br/>");
				print("PVP:<input type='text' name='pvp' value='".$_POST['pvp']."' disabled><span>No se han actualizado los datos inserte un pvp</span><br/>");
				?>
				<input type="hidden" name="ocultoCancelado" value="<?php echo $_POST['ocultoActualiza'];?>">
				<?php
			}elseif (isset($_POST['cancelar'])){ // No actualiza, porque se ha pulsado en editar.php cancelar
				print("<h1>Producto:</h1>");
				print("Nombre corto:<input type='text' name='nombrecorto' value='".$_POST['nombrecorto']."' disabled><br/>");
				print("Nombre:</br>");
				print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$_POST['nombre']."' disabled>".$_POST['nombre']."</textarea><br/>");
				print("Descripción:<br/>");
				print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$_POST['descripcion']."' disabled>".$_POST['descripcion']."</textarea><br/>");
				print("PVP:<input type='text' name='pvp' value='".$_POST['pvp']."' disabled><br/>");
				print("<span>Ha cancelado, no se han actualizado los datos</span><br/>");
				?>
				<input type="hidden" name="ocultoCancelado" value="<?php echo $_POST['ocultoActualiza'];?>">
				<?php
			}

		?>
		<input type="submit" name="continuar" value="Continuar">
	</form>
	<?php
				mysqli_commit($mbd);
				
				mysqli_close($mbd);
	?>
</body>
</html>