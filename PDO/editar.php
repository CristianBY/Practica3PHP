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
			try{ //Probamos conexión
				$mbd = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'Aabc123.',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$sentenciaBuscaEditable = $mbd->prepare("SELECT nombre,nombre_corto,descripcion,PVP,familia FROM producto where cod = ?");
				$sentenciaBuscaEditable->bindParam(1,$_POST['ocultoEdita']);
				$sentenciaBuscaEditable->execute();
				while ($fila = $sentenciaBuscaEditable->fetch()) { //Rellenamos el formulario con los datos actuales del producto selecionado y habilitamos su edición.
					$nombre = $fila[0];
					$nombrecorto = $fila[1];
					$descripcion = $fila[2];
					$pvp = $fila[3];
					$familia = $fila[4];
					print("<form action='actualizar.php' method='POST'>");
					print("Nombre corto:<input type='text' name='nombrecorto' value='".$nombrecorto."'><br/>");
					print("Nombre:</br>");
					print("<textarea type='text' cols='40' rows='1' name='nombre' value='".$nombre."'>".$nombre."</textarea><br/>");
					print("Descripción:<br/>");
					print("<textarea type='text' cols='40' rows='10' name='descripcion' value='".$descripcion."'>".$descripcion."</textarea><br/>");
					print("PVP:<input type='text' name='pvp' value='".$pvp."'><br/>");
				}
				$mbd = null;
			} catch (Exception $e) { //Para controlar errores de conexión
				die("Unable to connect: " . $e->getMessage());
			}
		?>
		<input type="hidden" name="ocultoCodigo" value="<?php echo $_POST['ocultoEdita'];?>">
		<input type="hidden" name="ocultoActualiza" value="<?php echo $familia;?>">
		<input type="submit" name="actualizar" value="Actualizar">
		<input type="submit" name="cancelar" value="Cancelar">

	</div>
</body>
</html>