<?php
include 'header.php';

// API DE NOTÍCIAS - GNEWS
$apiKey = "76b81caa2efc58be7b25bc5d95d661f1";

$url = "https://gnews.io/api/v4/search?q=finance&lang=pt&country=br&max=12&apikey=$apiKey";

// Inicializa cURL
$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);

if (!$response) {
    $noticias = [];
} else {
    $data = json_decode($response, true);
    $noticias = $data["articles"] ?? [];
}

curl_close($ch);

// Limitar para 6 notícias
$noticias = array_slice($noticias, 0, 6);

// Função para sanitizar texto
function safe($s) {
    return htmlspecialchars($s ?? "", ENT_QUOTES, "UTF-8");
}
?>

<section class="section-spaced">
    <div class="container">

        <!-- Título -->
        <div class="d-flex align-items-center gap-2 mb-4">
            <span class="brand-tag">ZENNO</span>
            <h2 class="fw-bold mb-0">Artigos</h2>
        </div>

        <!-- Cards -->
        <div class="row g-4">

            <?php if (empty($noticias)): ?>
                <p>Nenhuma notícia disponível no momento.</p>

            <?php else: ?>
                <?php foreach ($noticias as $n): ?>

                    <?php
                    $title = safe($n["title"]);
                    $desc = safe($n["description"]);
                    $img = safe($n["image"]);
                    $urlNoticia = safe($n["url"]);
                    $dataPub = $n["publishedAt"];
                    ?>

                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm card-news">

                            <?php if (!empty($img)): ?>
                                <img class="imagens-artigos" src="<?= $img ?>" alt="Imagem da notícia">
                            <?php else: ?>
                                <img class="imagens-artigos" src="img/placeholder.png" alt="Sem imagem">
                            <?php endif; ?>

                            <div class="card-body">

                                <h5 class="card-title"><?= $title ?></h5>

                                <?php if (!empty($desc)): ?>
                                    <p><?= $desc ?></p>
                                <?php endif; ?>

                                <a href="<?= $urlNoticia ?>" target="_blank" class="btn btn-zenno-dark btn-sm mt-2">
                                    Ler matéria completa
                                </a>

                                <?php if (!empty($dataPub)): ?>
                                    <p class="mb-0 mt-2">
                                        <small>
                                            <?= date("d/m/Y H:i", strtotime($dataPub)) ?>
                                        </small>
                                    </p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
</section>

<?php include 'footer.php'; ?>
