<?php

include 'CONEXION.php';


$pdo=new conexion();


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])&& ($_GET['usuario']) && $_GET['contrasena'])
    {

        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id=:id and usuario=:usuario and contrasena=:contrasena");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();

        if($sql->rowCount()):
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            return $sql;
        header("HTTP/1.1 200 Iniciado sesion");
        echo json_encode($sql->fetchAll());
        exit;				
        
        } else {
    
        #$sql = $pdo->prepare("SELECT * FROM usuarios");
        #$sql->execute();
        #$sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 No hay existe usuario");
        #echo json_encode($sql->fetchAll());
        exit;		
    }
}


if ($_SERVER["REQUEST_METHOD"]=="POST") {

    
    $sql="INSER INTO usuarios (nombres, correo, usuario,contrasena,direccion,telefono,fecha_de_nacimiento) values (:nombres, :correo, :usuario, :contrasena, :direccion, :telefono, :fecha_de_nacimiento)";

    $stmt=$pdo->prepare($sql);

    $stmt-> bindValue('nombres',$_POST['nombres']);
    $stmt-> bindValue('correo',$__POST['correo']);
    $stmt-> bindValue('usuario',$__POST['usuario']);
    $stmt-> bindValue('contrasena',$_POST['contrasena']);
    $stmt-> bindValue('telefono',$_POST['telefono']);
    $stmt-> bindValue('fecha_de_nacimiento',$_POST['fecha_de_nacimiento']);
    $stmt->execute();

    $idPost=$pdo->lastInsertId();

    if($idPost){
        header("HTTP/1.1 200 OK");
        echo json_encode($idPost);
    }
    

}


?>