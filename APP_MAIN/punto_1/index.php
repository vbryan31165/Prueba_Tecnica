<?php

include 'CONEXION.php';


$pdo=new conexion();


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id']))
    {
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id=:id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 hay datos");
        echo json_encode($sql->fetchAll());
        exit;				
        
        } else {
        
        $sql = $pdo->prepare("SELECT * FROM usuarios");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 hay datos");
        echo json_encode($sql->fetchAll());
        exit;		
    }
}


if ($_SERVER["REQUEST_METHOD"]=="POST") {
    
    $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasena, direccion, telefono, fecha_de_nacimiento) VALUES(:nombre, :correo, :usuario, :contrasena, :direccion, :telefono, :fecha_de_nacimiento)";

    $stmt=$pdo->prepare($sql);
    $stmt-> bindValue('nombre',$_POST['nombre']);
    $stmt-> bindValue('correo',$_POST['correo']);
    $stmt-> bindValue('usuario',$_POST['usuario']);
    $stmt-> bindValue('contrasena',$_POST['contrasena']);
    $stmt-> bindvalue('direccion',$_POST['direccion']);
    $stmt-> bindValue('telefono',$_POST['telefono']);
    $stmt-> bindValue('fecha_de_nacimiento',$_POST['fecha_de_nacimiento']);
    $stmt->execute();
    $idPost=$pdo->lastInsertId();
    header("HTTP/1.1 200 usuario Registrado");

    if($idPost){
        header("HTTP/1.1 200 OK");
        echo json_encode($idPost);
    }
    

}
?>