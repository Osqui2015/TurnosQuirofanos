<?php
session_start();
if ($_SESSION['tipo'] == 1){
    header('location: admin');
}else if($_SESSION['tipo'] == 2){
    header('location: medico');
}else if($_SESSION['tipo'] == 3){
    header('location: consulta');
}else if($_SESSION['tipo'] == 4){
    header('location: turnos');
}else if($_SESSION['tipo'] == 5){
    header('location: gerente');
}else{
    header('location: ../');
}
?>
