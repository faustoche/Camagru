<main class="container">

	<p class="section-title">Latest artworks</p>

	<div class="gallery-grid">

		<?php if (empty($images)): ?>
			<div class="gallery-empty">
				<span class="big-icon">📷</span>
				No photos yet — be the first to create one!
			</div>
		<?php else: ?>
			<?php foreach ($images as $img): ?>
				<div class="gallery-item">
					<img src="/uploads/<?= htmlspecialchars($img['filename']) ?>" alt="Photo by <?= htmlspecialchars($img['username']) ?>">
					<div class="overlay">
						<span style="font-size:0.8rem; color:#fff;">
							★ <?= (int)$img['likes'] ?> &nbsp; by <?= htmlspecialchars($img['username']) ?>
						</span>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>

	</div>

	<?php if (!empty($images)): ?>
		<p class="pagination">
			Page <?= (int)($currentPage ?? 1) ?> / <?= (int)($totalPages ?? 1) ?>
			&nbsp;·&nbsp; <?= (int)($totalImages ?? 0) ?> photos
		</p>
	<?php endif; ?>

</main>