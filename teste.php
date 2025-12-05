<?php
$result = file_put_contents("arquivo_teste.txt", "Funcionou!");
if ($result !== false) {
    echo "Arquivo criado com sucesso!";
} else {
    echo "Falha ao criar arquivo.";
}
