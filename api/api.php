<?php 
require_once '../connection/connect.php';

$func = $_POST['function'];
$dados = $_POST['data'] ?? [];
$arrDados = json_decode($dados, true);

if (function_exists($func)) {
    echo call_user_func($func, $arrDados);
}

function sqlGetNext($tabela, $campo) {
	global $mysqli;

    $sql = "SELECT MAX($campo) AS max_val FROM $tabela";
	$result = $mysqli->query($sql);

	if ($result) {
		$row = $result->fetch_assoc();
		$maxVal = $row['max_val'];

		return ($maxVal !== null) ? $maxVal + 1 : 1;
	} else {
		return 1;
	}
}

function getLastRow($idTarefa) {
	global $mysqli;

	$stmt = $mysqli->prepare("SELECT MAX(id_item) AS max_val FROM itens_tarefa WHERE id_tarefa = ?");
	$stmt->bind_param("s", $idTarefa);

	$stmt->execute();
	$stmt->bind_result($maxVal);
	$stmt->fetch();

	return ($maxVal !== null) ? (int) $maxVal : 1;
}


function saveItensTarefa($idTarefa, $info) {
    global $mysqli;

	$arrId = [];
	foreach ($info as $v1) {
		$ativo = $v1['status'] ? 'N' : 'S';
		$desc = $v1['desc'];
		
		if(empty($v1['id'])) {
			$stmt = $mysqli->prepare("INSERT INTO itens_tarefa (desc_item, ativo, id_tarefa) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $desc, $ativo, $idTarefa);

			if (!$stmt->execute()) {
				return false; // Se qualquer insert ou update falhar, retorna false
			}

			$arrId[] = getLastRow($idTarefa);
		} else {
			$stmt = $mysqli->prepare("UPDATE itens_tarefa SET desc_item = ?, ativo = ? WHERE id_item = ?");
			$stmt->bind_param("sss", $desc, $ativo, $v1['id']);

			if (!$stmt->execute()) {
				return false; // Se qualquer insert ou update falhar, retorna false
			}

			$arrId[] = $v1['id'];
		}
    }

	if(count($arrId) > 0) {
		// Força todos os valores a serem inteiros por segurança
		$arrId = array_map('intval', $arrId);

		// Concatena os IDs com vírgula
		$arrStr = implode(',', $arrId);
	
		// Executa o DELETE com a string de IDs
		$sql = "DELETE FROM itens_tarefa WHERE id_tarefa = ? AND id_item NOT IN ($arrStr)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $idTarefa);
	
		if (!$stmt->execute()) {
			return false;
		}
	}

    return true;
}

function cadastraTarefa($data) {
    global $mysqli;

    parse_str($data['formData'], $arrDataTarefa);

    $dataCad = date('Ymd');
    $horaCad = date('H:i');

    $idTarefa = 0;
    if(empty($arrDataTarefa['idTarefa'])) {
        $idTarefa = sqlGetNext('lista_tarefas', 'id_tarefa');
        $sql = $mysqli->prepare("INSERT INTO lista_tarefas (nome_tarefa, assunto, prioridade, finalizacao, observacao, data_cad, hora) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssssss", $arrDataTarefa['nmTarefa'], $arrDataTarefa['assunto'], $arrDataTarefa['prioridade'], $arrDataTarefa['dtVenc'], $arrDataTarefa['obsTarefa'], $dataCad, $horaCad);
    } else {
        $idTarefa = $arrDataTarefa['idTarefa'];
        $sql = $mysqli->prepare("UPDATE lista_tarefas SET assunto = '{$arrDataTarefa['assunto']}', prioridade = '{$arrDataTarefa['prioridade']}', finalizacao = '{$arrDataTarefa['dtVenc']}', observacao = '{$arrDataTarefa['obsTarefa']}' WHERE id_tarefa = {$arrDataTarefa['idTarefa']}");
    }

    if ($sql->execute()) {
        if(count($data['data']) > 0) {
            $svItens = saveItensTarefa($idTarefa, $data['data']);
            echo json_encode(['ok' => $svItens]);
        } else {
            echo json_encode(['ok' => true]);
        }
    } else {
        echo json_encode(['ok' => true, 'msg' => $sql->error]);
    }
}

function getTarefas() {
    global $mysqli;
    
    $sql = $mysqli->prepare("SELECT * FROM lista_tarefas WHERE status_tarefa = 'P'");
    $sql->execute();

    $resultado = $sql->get_result();
    $dados = $resultado->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['data' => $dados]);
}

function getTarefasFinalizadas() {
    global $mysqli;
    
    $sql = $mysqli->prepare("SELECT * FROM lista_tarefas WHERE status_tarefa = 'F'");
    $sql->execute();

    $resultado = $sql->get_result();
    $dados = $resultado->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['data' => $dados]);
}

function getTarefa($data) {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT * FROM lista_tarefas WHERE id_tarefa = ?");
    $stmt->bind_param("i", $data);
    $stmt->execute();

    $result = $stmt->get_result();
    $dadosTarefa = $result->fetch_object();

    /* VERIFICA SE EXISTE ITENS NA TAREFA */
    $stmt = $mysqli->prepare("SELECT * FROM itens_tarefa WHERE id_tarefa = ?");
    $stmt->bind_param("i", $data);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $itens = $resultado->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['dadosTarefa' => $dadosTarefa, 'itens' => $itens]);
}

function finalizarTarefa($params) {
	global $mysqli;

	$date = date('Ymd');
	if($params['acao']) {
		$stmt = $mysqli->prepare("UPDATE lista_tarefas SET status_tarefa = 'F', data_finalizacao = '{$date}' WHERE id_tarefa = ?");
		$stmt->bind_param("i", $params['idTarefa']);
	} else {
		$stmt = $mysqli->prepare("UPDATE lista_tarefas SET status_tarefa = 'P', data_finalizacao = '' WHERE id_tarefa = ?");
		$stmt->bind_param("i", $params['idTarefa']);
	}
    
	$cond = '';
    if ($stmt->execute()) {
        $cond = true;
    } else {
        $cond = false;
    }

	echo json_encode(['ok' => $cond]);
}