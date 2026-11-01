<?php
$currentLive = $live[0] ?? null;
$videoUrl = $currentLive['video_url'] ?? '';
$videoId = '';

if ($videoUrl) {
    $videoParts = parse_url($videoUrl);
    $videoHost = $videoParts['host'] ?? '';
    parse_str($videoParts['query'] ?? '', $videoQuery);
    if (isset($videoQuery['v'])) {
        $videoId = $videoQuery['v'];
    } elseif (str_contains($videoHost, 'youtu.be')) {
        $videoId = trim($videoParts['path'] ?? '', '/');
    } elseif (str_contains($videoUrl, '/embed/')) {
        $videoId = basename(parse_url($videoUrl, PHP_URL_PATH));
    }
}
$embedUrl = $videoId ? 'https://www.youtube.com/embed/' . rawurlencode($videoId) . '?rel=0' : null;
?>
<section class="page-wrap">
    <div class="page-title">
        <span class="section-kicker">Rachel en direct</span>
        <h1>Live YouTube</h1>
        <p>Retrouvez ici les diffusions en direct et les replays de Rachel.</p>
    </div>
    <?php if ($currentLive && $embedUrl): ?>
        <article class="panel live-player-panel" style="overflow:hidden;">
            <div class="live-player" style="aspect-ratio:16/9; background:#16251d;">
                <iframe src="<?= htmlspecialchars($embedUrl) ?>" title="<?= htmlspecialchars($currentLive['title']) ?>" style="width:100%;height:100%;border:0;display:block;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <div class="live-player-copy">
                <span class="section-kicker"><span class="live-dot"></span> En direct ou replay</span>
                <h2><?= htmlspecialchars($currentLive['title']) ?></h2>
                <p><?= htmlspecialchars($currentLive['excerpt']) ?></p>
            </div>
        </article>
    <?php else: ?>
        <section class="feature-live">
            <div class="live-copy">
                <span class="section-kicker">Prochain rendez-vous</span>
                <h2>Le prochain live arrive bientôt.</h2>
                <p>Rachel publiera ici le lien YouTube dès que la diffusion sera programmée.</p>
            </div>
        </section>
    <?php endif; ?>
</section>
