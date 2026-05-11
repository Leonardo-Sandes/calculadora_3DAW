<?php
$resultado = null;
$erro = '';
$a = $_POST['a'] ?? '';
$b = $_POST['b'] ?? '';
$conta = $_POST['conta'] ?? '+';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($a === '' || $b === '') {
        $erro = 'ENTRE COM 2 NÚMEROS!';
    } elseif (!is_numeric($a) || !is_numeric($b)) {
        $erro = 'TEM QUE SER NÚMERO!';
    } else {
        $num_a = (float)$a;
        $num_b = (float)$b;

        switch ($conta) {
            case '+':
                $resultado = $num_a + $num_b;
                break;
            case '-':
                $resultado = $num_a - $num_b;
                break;
            case '*':
                $resultado = $num_a * $num_b;
                break;
            case '/':
                if ($num_b == 0.0) {
                    $erro = 'DIVISÃO POR 0!';
                } else {
                    $resultado = $num_a / $num_b;
                }
                break;
            case '**':
                $resultado = pow($num_a, $num_b);
                break;
            case 'raiz':
                if ($num_b <= 0) {
                    $erro = 'ÍNDICE DA RAIZ DEVE SER MAIOR QUE 0!';
                } elseif ($num_a < 0 && $num_b % 2 == 0) {
                    $erro = 'RAIZ PAR DE NÚMERO NEGATIVO É INVÁLIDA!';
                } else {
                    $resultado = pow($num_a, 1 / $num_b);
                }
                break;
            default:
                $erro = 'Operação inválida.';
        }
    }
}

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Calculadora Pro</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 480px; margin: 40px auto; border: 2px solid black; border-radius: 5px; padding: 20px; }
        label, select, input { display: block; margin: 8px 0; width: 100%; box-sizing: border-box; }
        input { padding: 8px; }
        button { width: 100%; padding: 10px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; transition: background 0.3s; }
        button:hover { background: #0056b3; }
        .resultado { margin-top: 16px; padding: 10px; background:#f2f2f2; border: 5px solid #ccc; border-radius: 10px; font-weight: bold; text-align: center; }
        .erro { color:red; border-color: #ffcccc; background: #ffe6e6; }
    </style>
</head>
<body>
    <h2>Calculadora</h2>
    
    <form id="calcForm" method="post" action="">
        <label>Número A 
            <input type="text" id="num_a" name="a" value="<?php echo e($a); ?>" autocomplete="off">
        </label>
        <label>Número B 
            <input type="text" id="num_b" name="b" value="<?php echo e($b); ?>" autocomplete="off">
        </label>
        <label>Operações
            <select id="operacao" name="conta">
                <option value="+" <?php if ($conta=='+') echo 'selected'; ?>>Soma (+)</option>
                <option value="-" <?php if ($conta=='-') echo 'selected'; ?>>Subtração (-)</option>
                <option value="*" <?php if ($conta=='*') echo 'selected'; ?>>Multiplicação (*)</option>
                <option value="/" <?php if ($conta=='/') echo 'selected'; ?>>Divisão (/)</option>
                <option value="**" <?php if ($conta=='**') echo 'selected'; ?>>Potenciação (A^B)</option>
                <option value="raiz" <?php if ($conta=='raiz') echo 'selected'; ?>>Radiciação (Raiz B de A)</option>
            </select>
        </label>
        <button type="submit">Calcular</button>
    </form>

    <div id="js_erro_container" class="resultado erro" style="display: none;"></div>

    <?php if ($erro): ?>
        <div class="resultado erro"><?php echo e($erro); ?></div>
    <?php elseif ($resultado !== null): ?>
        <div class="resultado">Resultado: <?php echo e($resultado); ?></div>
    <?php endif; ?>

    <script>
        document.getElementById('calcForm').addEventListener('submit', function(event) {

            const valA = document.getElementById('num_a').value.trim();
            const valB = document.getElementById('num_b').value.trim();
            const operacao = document.getElementById('operacao').value;
            const jsErroContainer = document.getElementById('js_erro_container');

            jsErroContainer.style.display = 'none';
            jsErroContainer.innerText = '';

            function dispararErro(mensagem) {
                event.preventDefault(); 
                jsErroContainer.innerText = mensagem;
                jsErroContainer.style.display = 'block';
            }

            if (valA === '' || valB === '') {
                dispararErro('⚠️ Preencha os dois campos antes de calcular!');
                return;
            }

            const numA = parseFloat(valA.replace(',', '.'));
            const numB = parseFloat(valB.replace(',', '.'));

            if (isNaN(numA) || isNaN(numB)) {
                dispararErro('⚠️ Por favor, digite apenas números válidos!');
                return;
            }

            if (operacao === '/' && numB === 0) {
                dispararErro('⚠️ Não é possível dividir um número por zero!');
                return;
            }

            if (operacao === 'raiz') {
                if (numB <= 0) {
                    dispararErro('⚠️ O índice da raiz (Número B) deve ser maior que zero!');
                    return;
                }
                if (numA < 0 && numB % 2 === 0) {
                    dispararErro('⚠️ Raiz par de número negativo não existe no conjunto dos Reais!');
                    return;
                }
            }
            
        });
    </script>
</body>
</html>
