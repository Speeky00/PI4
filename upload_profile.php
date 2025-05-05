<?php
header('Content-Type: application/json');

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Verifica se o userId foi enviado
if (!isset($_POST['userId']) || empty($_POST['userId'])) {
    echo json_encode(['success' => false, 'message' => 'ID do usuário não fornecido']);
    exit;
}

$userId = $_POST['userId'];

// Verifica se um arquivo foi enviado
if (!isset($_FILES['profileImage']) || $_FILES['profileImage']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Nenhuma imagem enviada ou erro no upload']);
    exit;
}

// Informações do arquivo
$fileTmpPath = $_FILES['profileImage']['tmp_name'];
$fileName = $_FILES['profileImage']['name'];
$fileSize = $_FILES['profileImage']['size'];
$fileType = $_FILES['profileImage']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

// Verifica se é uma imagem
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido. Use apenas imagens (JPG, PNG, GIF)']);
    exit;
}

// Verifica o tamanho do arquivo (máximo 2MB)
if ($fileSize > 2097152) {
    echo json_encode(['success' => false, 'message' => 'O arquivo é muito grande. Tamanho máximo permitido: 2MB']);
    exit;
}

// Diretório de destino
$uploadDir = 'img/';
$destPath = $uploadDir . 'profile_' . $userId . '.jpg';

// Tenta mover o arquivo para o diretório de destino
if (move_uploaded_file($fileTmpPath, $destPath)) {
    // Se for PNG ou GIF, converte para JPG
    if ($fileExtension !== 'jpg' && $fileExtension !== 'jpeg') {
        $image = null;
        switch ($fileExtension) {
            case 'png':
                $image = imagecreatefrompng($destPath);
                break;
            case 'gif':
                $image = imagecreatefromgif($destPath);
                break;
        }
        
        if ($image !== null) {
            // Converte para JPG e substitui o arquivo original
            imagejpeg($image, $destPath, 90);
            imagedestroy($image);
        }
    }
    
    echo json_encode(['success' => true, 'message' => 'Upload realizado com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao mover o arquivo para o diretório de destino']);
}
?>  