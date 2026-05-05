<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */
?>

<!-- add class collapsed to start with sidebar open -->
<nav id="sidebar" class="sidebar js-sidebar ">
	<div class="sidebar-content js-simplebar" data-simplebar="init">
		<div class="simplebar-wrapper" style="margin: 0px;">
			<div class="simplebar-height-auto-observer-wrapper">
				<div class="simplebar-height-auto-observer"></div>
			</div>
			<div class="simplebar-mask">
				<div class="simplebar-offset" style="right: 0px; bottom: 0px;">
					<div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
						<div class="simplebar-content" style="padding: 0px;">
							<!-- ADD LOGO HERE -->
							<a class="sidebar-brand" href="<?= Url::to(['site/index']); ?>">
								<?= Html::img(Yii::getAlias('@backendImg') . "/logo.svg", ['width' => '180px',]) ?>
							</a>

							<h3 class="website">Sito web</h3>

							<ul class="sidebar-nav">
								<!--<li class="sidebar-header">
								Site
							</li>-->

								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'site') echo "active"; ?>" href="<?= Url::to(['site/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home align-middle me-2">
											<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
											<polyline points="9 22 9 12 15 12 15 22"></polyline>
										</svg>
										<span>Home</span>
									</a>
								</li>
								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'company') echo "active"; ?>" href="<?= Url::to(['company/update']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
											<path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
											<path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
										</svg>
										<span><?= Yii::t('backend', 'Company') ?></span>
									</a>
								</li>
								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'gara') echo "active"; ?>" href="<?= Url::to(['gara/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home align-middle me-2">
											<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
											<polyline points="9 22 9 12 15 12 15 22"></polyline>
										</svg>
										<span>Gara</span>
									</a>
								</li>
								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'foto-gara') echo "active"; ?>" href="<?= Url::to(['foto-gara/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
											<path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
										</svg>
										<span>Aggiungi foto a gara</span>
									</a>
								</li>
								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'pages') echo "active"; ?>" href="<?= Url::to(['pages/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
											<path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
										</svg>
										<span><?= Yii::t('backend', 'Page Management') ?></span>
									</a>
								</li>
								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'image') echo "active"; ?>" href="<?= Url::to(['image/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
											<path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
											<path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
										</svg>
										<span>Immagini</span>
									</a>
								</li>

								<li>
									<a class="sidebar-link <?php if (Yii::$app->controller->id == 'cart') echo "active"; ?>" href="<?= Url::to(['cart/index']); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
											<path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
											<path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
										</svg>
										<span>Richieste</span>
									</a>
								</li>
								
							</ul>

							<!-- Brand footer 
							<div class="iosystems-brand">
								<a href="https://www.iosystems.it/" target="_blank">
									<span class="align-middle">Proudly powered by </span>
									<?= Html::img(Yii::getAlias('@backendImg') . "/admin-logo-iosystems.png") ?>
								</a>
							</div>-->
						</div>
					</div>
				</div>
			</div>
			<div class="simplebar-placeholder" style="width: auto; height: 958px;"></div>
		</div>
		<div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
			<div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
		</div>
		<div class="simplebar-track simplebar-vertical" style="visibility: visible;">
			<div class="simplebar-scrollbar" style="height: 51px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
		</div>
	</div>
</nav><!-- end nav -->