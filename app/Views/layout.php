<?php
$isApp = str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', app_url('/app')) || str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', app_url('/admin'));
ob_start(static function (string $html): string {
	$html = str_replace('Rachel Martin', 'Rachel Cayzac', $html);
	$html = str_replace('<a href="/app/conseils">Conseils</a>', '<a href="/app/conseils">Conseils</a><a href="/app/live">Live</a>', $html);
	if (APP_BASE_PATH !== '') {
		$html = str_replace(
			['href="/', 'action="/', 'src="/'],
			['href="' . APP_BASE_PATH . '/', 'action="' . APP_BASE_PATH . '/', 'src="' . APP_BASE_PATH . '/'],
			$html
		);
	}
	return $html;
});
?>
<script>document.addEventListener('DOMContentLoaded', function () { const base = <?= json_encode(APP_BASE_PATH) ?>; if (!base) return; document.querySelectorAll('a[href], form[action]').forEach(function (element) { const attribute = element.hasAttribute('href') ? 'href' : 'action'; const value = element.getAttribute(attribute); if (value && value.startsWith('/') && !value.startsWith(base + '/')) element.setAttribute(attribute, base + value); }); });</script>
<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= htmlspecialchars($title ?? 'Rachel Naturo') ?></title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="/assets/style.css"></head><body class="<?= $isApp ? 'app-shell' : 'marketing-shell' ?>"><header class="topbar"><a class="brand" href="/"><span class="brand-mark">✿</span><span>rachel <b>naturo</b></span></a><?php if ($isApp && !empty($_SESSION['user'])): ?><nav><a href="/app">Accueil</a><a href="/app/conseils">Conseils</a><a href="/app/archives">Archives</a><?php if ($_SESSION['user']['role'] === 'admin'): ?><a href="/admin">Pilotage</a><?php endif; ?></nav><div class="user-menu"><span><?= htmlspecialchars($_SESSION['user']['name']) ?></span><form method="post" action="/deconnexion"><button class="icon-button" title="Se déconnecter">↗</button></form></div><?php else: ?><a class="text-link" href="/connexion">Se connecter <span>→</span></a><?php endif; ?></header><main><?php require __DIR__ . '/' . $template . '.php'; ?></main><footer><span>rachel naturo</span><span>La nature, simplement.</span></footer></body></html>
