<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <form method="post" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" name="ano_nascimento" placeholder="Ex: 2005" required><br>

        <button type="submit">Cadastrar</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $ano_nascimento = (int)$_POST['ano_nascimento'];
    
    $ano_atual = 2026;
    $idade = $ano_atual - $ano_nascimento;

    // --- QUAIS NASCIMENTOS NÃO SERÃO ACEITOS ---
    // 1. Anos curtos (ex: 2)
    // 2. Anos no futuro (maior que 2026)
    // 3. Pessoas com 120 anos ou mais
    if ($ano_nascimento < 1000 || $ano_nascimento > $ano_atual || $idade >= 120) {
        echo "<p style='color: red;'>Coloque uma data de nascimento válida!</p>";
    } 
    // --- DADOS VÁLIDOS (CONTINUA O CADASTRO) ---
    else {
        // Validação de maioridade
        if ($idade >= 18) {
            $mensagem = "Acesso liberado " . $nome . "!";
        } else {
            $mensagem = "Acesso negado " . $nome . "!";
        }

        // Exibe a mensagem na tela
        echo "<p>" . $mensagem . "</p>";

        // Salva no arquivo APENAS se passou na validação
        $arquivo = fopen('usuarios.txt', 'a');
        $linha = $nome . '; ' . $ano_nascimento . '; ' . $idade . ' anos; ' . $mensagem . "\n";
        fwrite($arquivo, $linha);
        fclose($arquivo);

        echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
    }
}
?>
</body>
</html>