<!DOCTYPE html>
<html>
<head>
	<title>editar</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
	<div class="cabecera">
		<h1>Tarea: Edición de un producto</h1>
	</div>
	<div class="contenido">
		<h1>Producto:</h1>	
		<?php
			$mbd = mysqli_connect('localhost','dwes','Aabc123.','dwes');
			mysqli_set_charset($mbd,'utf8');
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$sentenciaBuscaEditable = mysqli_prepare($mbd,"SELECT nombre,nombre_corto,descripcion,PVP,familia FROM producto where cod = ?");
			mysqli_stmt_bind_param($sentenciaBuscaEditable,'s',$_POST['ocultoEdita']);
			mysqli_stmt_execute($sentenciaBuscaEditable);
			$resultado = mysqli_stmt_get_result($sentenciaBuscaEditable);
			while ($fila = mysqli_fetch_assoc($resultado)) { //Rellenamos el formulario con los datos actuales del producto selecionado y habilitamos su edición.
				$nombre = $fila['nombre'];
				$nombrecorto = $fila['nombre_corto'];
				$descripcion = $fila['descripcion'];
				$pvp = $fila['PVP'];
				$familia = $fila['familia'];
				print("<form action='actualizar.php' method='POST'>");
				print("Nombre corto:<input type='text' name='nombrecorto' value='".$nombrecorto."'><br/>");
				print("Nombre:</br>");
				print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$nombre."'>".$nombre."</textarea><br/>");
				print("Descripción:<br/>");
				print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$descripcion."'>".$descripcion."</textarea><br/>");
				print("PVP:<input type='text' name='pvp' value='".$pvp."'><br/>");
			}
			
		?>
		<input type="hidden" name="ocultoCodigo" value="<?php echo $_POST['ocultoEdita'];?>">
		<input type="hidden" name="ocultoActualiza" value="<?php echo $familia;?>">
		<input type="submit" name="actualizar" value="Actualizar">
		<input type="submit" name="cancelar" value="Cancelar">
		<?php
			mysqli_free_result($sentenciaBuscaEditable);
			mysqli_close($sentenciaBuscaEditable);
			mysqli_close($mbd);
		?>
	</div>
</body>
</html>