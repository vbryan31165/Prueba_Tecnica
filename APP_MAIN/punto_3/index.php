<?php

	include 'conexion.php';
	
	$pdo = new Conexion();
	
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(isset($_GET['id']))
		{
			$sql = $pdo->prepare("SELECT * FROM productos WHERE id=:id");
			$sql->bindValue(':id', $_GET['id']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 no se encuentra producto");
			echo json_encode($sql->fetchAll());
			exit;				
			
			} else {
			
			$sql = $pdo->prepare("SELECT * FROM productos");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay productos");
			echo json_encode($sql->fetchAll());
			exit;		
		}
	}
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$sql = "INSERT INTO productos (nombre, valor, cantidad) VALUES(:nombre, :valor, :cantidad)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_POST['nombre']);
		$stmt->bindValue(':valor', $_POST['valor']);
		$stmt->bindValue(':cantidad', $_POST['cantidad']);
		$stmt->execute();
		$idPost = $pdo->lastInsertId(); 
		if($idPost)
		{
			header("HTTP/1.1 200 OK registrado");
			echo json_encode($idPost);
			exit;
		}
	}
	
	
	if($_SERVER['REQUEST_METHOD'] == 'PUT')
	{		
		$sql = "UPDATE productos SET nombre=:nombre, valor=:valor, cantidad=:cantidad WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_POST['nombre']);
		$stmt->bindValue(':valor', $_POST['valor']);
		$stmt->bindValue(':cantidad', $_POST['cantidad']);
		$stmt->bindValue(':id', $_GET['id']);
		
		$stmt->execute();
		header("HTTP/1.1 200 Ok Se ha actualizado los datos");
		exit;
	}
	
	
	if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM productos WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Se ha eliminado el registro");
		exit;
	}
	
	header("HTTP/1.1 400 Bad Request");
?>