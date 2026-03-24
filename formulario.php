<?php

header('Content-Type: text/html; charset=utf-8');
$errors = [];
$success = false;
$total_compra = 0;
$dados_compra = [
    'produto' => '',
    'valor' => 0,
    'quantidade' => 0
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $dados_compra['produto'] = trim(htmlspecialchars($_POST['produto'] ?? ''));
    $dados_compra['valor'] = floatval(str_replace(',', '.', $_POST['valor'] ?? 0));
    $dados_compra['quantidade'] = intval($_POST['quantidade'] ?? 0);
    
    
    if ($dados_compra['produto'] === '') {
        $errors['produto'] = 'O nome do produto é obrigatório.';
    }
    
    if ($dados_compra['valor'] <= 0) {
        $errors['valor'] = 'Informe um valor válido (maior que zero).';
    }
    
    if ($dados_compra['quantidade'] <= 0) {
        $errors['quantidade'] = 'Informe uma quantidade válida (mínimo 1).';
    }
    
    
    $total_compra = $dados_compra['valor'] * $dados_compra['quantidade'];
    
    
    if (empty($errors)) {
        
        $linha = json_encode([
            'data' => date('Y-m-d H:i:s'),
            'produto' => $dados_compra['produto'],
            'valor_unitario' => $dados_compra['valor'],
            'quantidade' => $dados_compra['quantidade'],
            'total_compra' => $total_compra
        ], JSON_UNESCAPED_UNICODE) . PHP_EOL;
        
        
        $arquivo = __DIR__ . '/compras.txt';
        if (file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX) !== false) {
            $success = true;
        } else {
            $errors['geral'] = 'Não foi possível gravar a compra. Tente novamente mais tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .error-list {
            margin: 0;
            padding-left: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .info-card {
            background-color: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-row {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #cce5ff;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
            color: #004085;
        }
        .info-value {
            display: inline-block;
            color: #004085;
        }
        .total {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #d4edda;
            border-radius: 8px;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .valor-destaque {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($errors)): ?>
            <div class="error">
                <h3>❌ Erros encontrados:</h3>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="formulario.php" class="btn">Voltar e corrigir</a>
            </div>
        <?php elseif ($success): ?>
            <div class="success">
                ✅ Compra registrada com sucesso!
            </div>
            
            <h2>📋 Detalhes da Compra</h2>
            
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Produto:</span>
                    <span class="info-value"><?php echo htmlspecialchars($dados_compra['produto']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Valor Unitário:</span>
                    <span class="info-value">R$ <?php echo number_format($dados_compra['valor'], 2, ',', '.'); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Quantidade:</span>
                    <span class="info-value"><?php echo $dados_compra['quantidade']; ?> unidade(s)</span>
                </div>
            </div>
            
            <div class="total">
                💰 TOTAL DA COMPRA: R$ <?php echo number_format($total_compra, 2, ',', '.'); ?>
            </div>
            
            <h3>📊 Resumo da Compra</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Valor Unitário</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($dados_compra['produto']); ?></td>
                        <td>R$ <?php echo number_format($dados_compra['valor'], 2, ',', '.'); ?></td>
                        <td><?php echo $dados_compra['quantidade']; ?></td>
                        <td class="valor-destaque">R$ <?php echo number_format($total_compra, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
            
            <div style="text-align: center;">
                <a href="formulario.php" class="btn">➕ Nova Compra</a>
            </div>
            
        <?php else: ?>
            <div class="error">
                <p>Nenhum dado foi enviado. Por favor, preencha o formulário.</p>
                <a href="formulario.php" class="btn">Ir para o formulário</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>