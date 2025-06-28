<?php 

/* ************************************************  */
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
/* ************************************************  */

$mysqli = new mysqli('localhost', 'root', 'Seizetheday25', 'tarefas');
$mysqli->set_charset("utf8mb4");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}
?>
