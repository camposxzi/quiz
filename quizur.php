<?php
$quiz = [
    [
        'question' => 'Quanto tempo leva uma sacola plástica para se decompor?',
        'options' => [
            'A' => '10 anos',
            'B' => '100 anos',
            'C' => '450 anos'
        ],
        'correct' => 'C'
    ],
    [
        'question' => 'O que são resíduos sólidos?',
        'options' => [
            'A' => 'Restos de líquidos indústrias',
            'B' => 'Gases poluentes do ar',
            'C' => 'Materiais descartados como lixo, que têm forma sólida',
            'D' => 'Poeira e fumaça'
        ],
        'correct' => 'C'
    ],
    [
        'question' => 'Qual desses materiais são recicláveis?',
        'options' => [
            'A' => 'Papel Higiênico',
            'B' => 'Garrafa PET',
            'C' => 'Frascos de remédio vazias',
            'D' => 'Pilhas e baterias'
        ],
        'correct' => 'B'
    ],
    [
        'question' => 'Qual desses materiais deve ser descartado na lixeira azul?',
        'options' => [
            'A' => 'Garrafa de vidro',
            'B' => 'Lata de refrigerante',
            'C' => 'Papel usado',
            'D' => 'Casca de fruta'
        ],
        'correct' => 'C'
    ],
    [
        'question' => 'Qual é a cor da lixeira usada para descartar vidro?',
        'options' => [
            'A' => 'Azul',
            'B' => 'Verde',
            'C' => 'Vermelha',
            'D' => 'Amarela'
        ],
        'correct' => 'B'
    ],
    [
        'question' => 'Qual dos 3 Rs representa a ação de transformar um material usado em um novo produto?',
        'options' => [
            'A' => 'Reduzir',
            'B' => 'Reutilizar',
            'C' => 'Reciclar',
            'D' => 'Reaproveitar'
        ],
        'correct' => 'C'
    ]
];

// Inicializar variáveis
$currentQuestion = isset($_GET['question']) ? (int)$_GET['question'] : 0;
$totalQuestions = count($quiz);
$score = isset($_GET['score']) ? (int)$_GET['score'] : 0;
$feedback = '';
$showResults = false;

// Processar resposta se houver submissão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $selectedAnswer = $_POST['answer'];
    $correctAnswer = $quiz[$currentQuestion]['correct'];
    
    if ($selectedAnswer === $correctAnswer) {
        $score++;
        $feedback = '<p class="correct">✅ Resposta correta!</p>';
    } else {
        $feedback = '<p class="incorrect">❌ Resposta incorreta. A correta era: ' . $quiz[$currentQuestion]['options'][$correctAnswer] . '</p>';
    }
    
    $currentQuestion++;
    
    if ($currentQuestion >= $totalQuestions) {
        $showResults = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Rápido com a Turma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #2b5166;
        }
        .question-container {
            background-color: whitesmoke;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .options {
            margin-top: 15px;
        }
        .option {
            display: block;
            margin: 10px ;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }
        .option:hover {
            background-color: #309292
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .correct {
            color: #0ca468;
        }
        .incorrect {
            color: red;
        }
        .results {
            text-align: center;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Quiz Que Se Você Acertar, Acertou</h1>
    
    <?php if (!$showResults): ?>
        <div class="progress">
            Pergunta <?php echo $currentQuestion + 1; ?> de <?php echo $totalQuestions; ?>
        </div>
        
        <?php echo $feedback; ?>
        
        <form method="POST" action="?question=<?php echo $currentQuestion; ?>&score=<?php echo $score; ?>">
            <div class="question-container">
                <h2><?php echo $quiz[$currentQuestion]['question']; ?></h2>
                
                <div class="options">
                    <?php foreach ($quiz[$currentQuestion]['options'] as $key => $value): ?>
                        <label class="option">
                            <input type="radio" name="answer" value="<?php echo $key; ?>" required> 
                            <?php echo $key . ') ' . $value; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <button type="submit">Próxima Pergunta</button>
        </form>
    <?php else: ?>
        <div class="results">
            <h2>Quiz Concluído!</h2>
            <p>Sua pontuação: <?php echo $score; ?> de <?php echo $totalQuestions; ?></p>
            <p>Porcentagem de acertos: <?php echo round(($score / $totalQuestions) * 100); ?>%</p>
            
            <a href="?question=0&score=0">
                <button>Refazer Quiz</button>
            </a>
        </div>
    <?php endif; ?>
</body>
</html>
