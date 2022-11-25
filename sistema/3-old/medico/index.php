<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['usuario']; /*VALOR USUARIO*/
require_once "../../conUsuario.php";


$con = mysqli_query($conUsuario, "SELECT m.fecha_creacion AS fecha, m.id_mensaje AS id,
              m.titulo, m.mensaje, 
              IF((us.userid=1), 'Administrador del Sistema', us.Nombre) AS Usuario
              FROM mensajes AS m 
              INNER JOIN mensajes_usuarios AS me ON me.id_mensaje = m.id_mensaje 
              LEFT JOIN usuarios AS us ON us.userid = m.id_usuario_creacion
              WHERE me.userid = $matricula ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema Medico</title>
    <?php  include_once "dependencias.php" ?>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
                <!–– Principal -->
                <div class="card-body">
                    <?php  include_once "principal.php" ?>
                </div>
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>
<script>
    $(document).ready(function() {
        $('#ModalBucarPractica1').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
        });
        $('#mensaje').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },        
        "dom": 'lrtip',
        fixedHeader: {
                header: true,
                footer: true,
                },
        ordering: false,
        "info": false,
        pageLength : 3,
        lengthMenu: [[3, 6, 9, -1], [3, 6, 9, 'Todos']]
        })

    });
</script>

</html>