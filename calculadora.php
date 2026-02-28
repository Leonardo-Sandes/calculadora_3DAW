
<?php
$resultado = null;
$erro = '';
$a = $_POST['a'] ?? '';
$b = $_POST['b'] ?? '';
$conta = $_POST['conta'] ?? '+';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($a === '' || $b === ''){
        $erro = 'ENTRE COM 2 NUMEROS!'; 
    }
    elseif (!is_numeric($a) || !is_numeric($b)){
        $erro = 'TEM QUE SER NUMERO!';
    }
    else{
        $x = (float)$a;
        $y = (float)$b;
        switch($conta){
            case '+':
                $resultado = $x + $y;
                break;
            case '-':
                $resultado = $x - $y;
                break;
            case '*':
                $resultado = $x * $y;
                break;
            case '/':
                if($y == 0.0){
                    $erro = 'DIVISÃO POR 0!';  
                    }   
                else{
                    $resultado = $x / $y;
                }
                    break;  
            default:
                $erro = 'Operação inválida.';
        }
}
}


?>



<?php
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Calculadora</title>

<style>
body { font-family: Arial, sans-serif; max-width: 480px; margin: 40px auto; border: 2px solid black; border-radius: 5px; padding: 20px 20px 20px 20px;}
label, select, input { display: block; margin: 8px 0; }
.resultado { margin-top: 16px; padding: 10px; background:#f2f2f2; border: 5px solid #ccc; border-radius: 10px; }
.erro { color:red; }
</style>


</head>
<body>
<h2>Calculadora</h2>
<form method="post" action="">
    <label>Numero A
        <input type="text" name="a" value="<?php echo e($a); ?>" autocomplete="off">
    </label>
    <label>Numero B
        <input type="text" name="b" value="<?php echo e($b); ?>" autocomplete="off">
    </label>
    <label>Operações
        <select name="conta">
            <option value="+" <?php if ($conta=='+') echo 'selected'; ?>>soma (+)</option>
            <option value="-" <?php if ($conta=='-') echo 'selected'; ?>>subtração (-)</option>
            <option value="*" <?php if ($conta=='*') echo 'selected'; ?>>multiplicação (*)</option>
            <option value="/" <?php if ($conta=='/') echo 'selected'; ?>>divisão (/)</option>
           
        </select>
    </label>
    <button type="submit">Calcular</button>
</form>
<?php if ($erro): ?>
    <div class="resultado erro"><?php echo e($erro); ?></div>
<?php elseif ($resultado !== null): ?>
    <div class="resultado">Resultado: <?php echo e($resultado); ?></div>
<?php endif; ?>

</body>
</html>