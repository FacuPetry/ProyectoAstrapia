<?php
$paisajesConfigPath = __DIR__ . '/../data/paisajes.json';
$paisajesConfig = [];

if (is_readable($paisajesConfigPath)) {
    $paisajesJson = file_get_contents($paisajesConfigPath);
    $paisajesConfig = json_decode($paisajesJson, true);
}

$paisajesSecciones = isset($paisajesConfig['secciones']) && is_array($paisajesConfig['secciones'])
    ? $paisajesConfig['secciones']
    : [];
$paisajesExtensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
$paisajesImagenes = [];
$paisajesIndiceOriginal = 0;

function paisajeEscapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function paisajeIdValido($id)
{
    return is_string($id) && preg_match('/^[a-z0-9-]+$/', $id);
}

function paisajeRutaValida($carpeta, $archivo, $extensionesPermitidas)
{
    if (!is_string($carpeta) || !is_string($archivo) || $archivo !== basename($archivo)) {
        return false;
    }

    $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    if (!in_array($extension, $extensionesPermitidas, true)) {
        return false;
    }

    $raizProyecto = realpath(__DIR__ . '/..');
    $rutaImagen = realpath(__DIR__ . '/../' . trim($carpeta, '/') . '/' . $archivo);

    return $raizProyecto !== false
        && $rutaImagen !== false
        && strncmp($rutaImagen, $raizProyecto . DIRECTORY_SEPARATOR, strlen($raizProyecto) + 1) === 0
        && is_file($rutaImagen);
}

foreach ($paisajesSecciones as $seccion) {
    $seccionId = $seccion['id'] ?? null;
    $carpeta = $seccion['carpeta'] ?? null;
    $imagenes = isset($seccion['imagenes']) && is_array($seccion['imagenes']) ? $seccion['imagenes'] : [];

    if (!paisajeIdValido($seccionId)) {
        continue;
    }

    foreach ($imagenes as $imagen) {
        $archivo = $imagen['archivo'] ?? null;
        if (!paisajeRutaValida($carpeta, $archivo, $paisajesExtensionesPermitidas)) {
            continue;
        }

        $imagen['_seccion_id'] = $seccionId;
        $imagen['_seccion_nombre'] = $seccion['nombre'] ?? '';
        $imagen['_carpeta'] = $carpeta;
        $imagen['_indice_original'] = $paisajesIndiceOriginal++;
        $paisajesImagenes[] = $imagen;
    }
}

usort($paisajesImagenes, function ($imagenA, $imagenB) {
    $ordenA = isset($imagenA['orden_global']) && is_numeric($imagenA['orden_global'])
        ? (float) $imagenA['orden_global']
        : PHP_FLOAT_MAX;
    $ordenB = isset($imagenB['orden_global']) && is_numeric($imagenB['orden_global'])
        ? (float) $imagenB['orden_global']
        : PHP_FLOAT_MAX;

    if ($ordenA === $ordenB) {
        return $imagenA['_indice_original'] <=> $imagenB['_indice_original'];
    }

    return $ordenA <=> $ordenB;
});
?>

<section id="nuestrospaisajes" class="section bg-color-light border-0 m-0 pb-0">
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col">
                <h3 class="text-center text-color-dark font-weight-bold text-transform-none text-10 mb-2">Bienvenidos a Astrapia</h3>
                <h2 class="text-center text-color-primary font-weight-semibold text-5 positive-ls-2 mb-2">Nuestros Paisajes</h2>
            </div>
        </div>
        <div class="row justify-content-center align-items-center mb-3">
            <div class="col-auto appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="600" data-appear-animation-duration="1.4s">
                <ul class="nav nav-pills sort-source sort-source-style-3 custom-center-pills text-2-5 mb-3 mb-md-4 mb-lg-3" data-sort-id="portfolio" data-option-key="filter">
                    <li class="nav-item line-height-1 ms-4 active" data-option-value="*">
                        <a class="nav-link font-weight-semibold text-color-hover-primary px-0" href="#">Mostrar Todos</a>
                    </li>
                    <?php foreach ($paisajesSecciones as $seccion): ?>
                        <?php if (!paisajeIdValido($seccion['id'] ?? null) || !isset($seccion['nombre'])) continue; ?>
                        <li class="nav-item line-height-1 ms-4" data-option-value=".<?= paisajeEscapar($seccion['id']) ?>">
                            <a class="nav-link font-weight-semibold text-color-hover-primary px-0" href="#"><?= paisajeEscapar($seccion['nombre']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800">
                <div class="sort-destination-loader sort-destination-loader-showing">
                    <div id="portfolioLoadMoreWrapper" class="row image-gallery sort-destination lightbox" data-sort-id="portfolio" data-initial-visible="8" data-load-step="4" data-plugin-options="{'delegate': 'a.lightbox-portfolio', 'type': 'image', 'gallery': {'enabled': true}}">
                        <?php foreach ($paisajesImagenes as $imagen): ?>
                            <?php
                            $seccionId = $imagen['_seccion_id'];
                            $archivo = $imagen['archivo'];
                            $rutaWeb = trim($imagen['_carpeta'], '/') . '/' . $archivo;
                            $leyenda = $imagen['leyenda'] ?? '';
                            $subleyenda = $imagen['subleyenda'] ?? $imagen['_seccion_nombre'];
                            $alt = $imagen['alt'] ?? trim($leyenda . ' ' . $subleyenda);
                            ?>
                            <div class="isotope-item col-sm-6 col-lg-3 <?= paisajeEscapar($seccionId) ?> p-0 js-load-more-item">
                                <div class="image-gallery-item mb-0">
                                    <a href="<?= paisajeEscapar($rutaWeb) ?>" class="lightbox-portfolio">
                                        <span class="thumb-info thumb-info-centered-info thumb-info-no-borders custom-thumb-info-style-1">
                                            <span class="thumb-info-wrapper">
                                                <img src="<?= paisajeEscapar($rutaWeb) ?>" class="img-fluid custom-paisaje-img" alt="<?= paisajeEscapar($alt) ?>" width="1000" height="1000" loading="lazy" decoding="async">
                                                <span class="thumb-info-title">
                                                    <span class="thumb-info-inner text-color-light"><?= paisajeEscapar($leyenda) ?></span>
                                                    <span class="thumb-info-type"><?= paisajeEscapar($subleyenda) ?></span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="portfolioLoadMoreBtnWrapper" class="row justify-content-center mt-4 mb-5">
                    <div class="col-auto text-center">
                        <p id="portfolioCounterLabel" class="text-color-dark font-weight-semibold mb-3"></p>
                        <button id="portfolioLoadMoreBtn" type="button" class="btn btn-gradient custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3 btn-px-5 btn-py-2">
                            VER MÁS FOTOS
                        </button>
                        <button id="portfolioShowLessBtn" type="button" class="btn btn-light custom-border-radius-1 d-none align-items-center font-weight-semibold text-3 btn-px-5 btn-py-2 ms-2">
                            VER MENOS
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>