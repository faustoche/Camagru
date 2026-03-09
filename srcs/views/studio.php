<div class="studio-app-wrapper">
    <div class="studio-app-window">

        <aside class="app-left-panel">
            <div class="app-search-bar">
                <input type="text" placeholder="Find a sticker ...">
                <button type="button" class="app-btn-small">OK</button>
            </div>
            
            <select class="app-select">
                <option>Best rated</option>
                <option>Newest</option>
            </select>

            <form action="/studio/capture" method="POST" enctype="multipart/form-data" id="mainCaptureForm" class="app-sticker-form">
                
                <input type="hidden" name="image_data" id="image_data">
                <input type="hidden" name="pos_x" id="pos_x">
                <input type="hidden" name="pos_y" id="pos_y">
                <input type="hidden" name="width" id="width">
                <input type="hidden" name="height" id="height">

                <div class="app-sticker-grid">
                    <?php if (!empty($stickers)): ?>
                        <?php foreach ($stickers as $index => $sticker): ?>
                            <label class="app-sticker-label">
                                <input type="radio" name="sticker" value="<?= htmlspecialchars($sticker) ?>" required>
                                <img src="/stickers/<?= htmlspecialchars($sticker) ?>" alt="Sticker">
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="app-empty-text">No stickers.</p>
                    <?php endif; ?>
                </div>

                <div class="app-pagination">
                    <button type="button" class="app-page-btn active">1</button>
                    <button type="button" class="app-page-btn">2</button>
                    <button type="button" class="app-page-btn">3</button>
                    <button type="button" class="app-page-btn">4</button>
                    <span>...</span>
                </div>
        </aside>

        <main class="app-center-panel">
            <div class="app-top-toolbar">
                <div class="toolbar-group">
                    <button type="button" class="toolbar-tool">📷<span>Webcam</span></button>
                    <label class="toolbar-tool upload-trigger">
                        ⬆<span>Upload</span>
                        <input type="file" name="userfile" accept="image/jpeg,image/png" style="display:none;">
                    </label>
                </div>
                <div class="toolbar-group">
                    <button type="button" class="toolbar-tool disabled">🗑️<span>Remove</span></button>
                    <button type="button" class="toolbar-tool disabled">⚙️<span>Settings</span></button>
                </div>
            </div>

            <div class="app-canvas-area">
                <div class="canvas-placeholder" style="position: relative;">
                    <span class="icon">📷</span>
                    
                    <video id="video" autoplay style="max-width: 100%; border-radius: 8px;"></video>
                    <div id="sticker-box" style="display: none; position: absolute; top: 10px; left: 10px; width: 120px; height: 120px; border: 2px dashed #ff00aa; resize: both; overflow: hidden; cursor: move; z-index: 10;">
						<img id="live-sticker" src="" alt="Sticker preview" style="width: 100%; height: 100%; object-fit: contain; pointer-events: none;" />
					</div>
					
					<canvas id="canvas" style="display:none;"></canvas>

                    <small>(Or uploaded image)</small>
                </div>
            </div>
            
            <div class="app-info-banner">
                ℹ️ You can use your webcam or upload a picture (JPG, PNG).
            </div>
        </main>

        <aside class="app-right-panel">
            <div class="right-panel-tools">
                <h3 class="panel-title">My Shots</h3>
                
                <div class="app-shots-grid">
                    <?php if (empty($userImages)): ?>
                        <div class="empty-dropzone">
                            <p>No photos yet</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($userImages as $img): ?>
                            <div class="app-shot-item">
                                <img src="/uploads/<?= htmlspecialchars($img['filename']) ?>" alt="Shot">
                                <div class="delete-form-placeholder">
                                    <button type="button" class="btn-delete-shot" title="Delete this image">✏️</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="right-panel-actions">
                <div class="zoom-controls">
                    <button type="button">🔍+</button>
                    <button type="button">⛶</button>
                    <button type="button">🔍-</button>
                    <span>100%</span>
                </div>
                <button type="submit" form="mainCaptureForm" class="app-btn-save">
                    ⬇ Capture
                </button>
            </div>
            </form> 
        </aside>

    </div>
</div>

<script>
    const video = document.getElementById('video');
    
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            video.srcObject = stream;
        })
        .catch(function(error) {
            console.error("Error: cannot access camera: ", error);
            alert("Cannot access camera. Please autorize access in your navigator.");
        });


	const stickerBox = document.getElementById('sticker-box');
	const liveSticker = document.getElementById('live-sticker');
	const stickerRadios = document.querySelectorAll('input[name="sticker"]');

	stickerRadios.forEach(radio => {
		radio.addEventListener('change', function() {
			liveSticker.src = '/stickers/' + this.value;
			stickerBox.style.display = 'block';
		});
	});

	let isDragging = false;
	let offsetX = 0;
	let offsetY = 0;

	stickerBox.addEventListener("mousedown", function(e) {
		// ne pas bloquer le clic si le user est sur le truc de redimensionnement
		if (e.offsetX > stickerBox.clientWidth - 20 && e.offsetY > stickerBox.clientHeight - 20) {
			return ;
		}

		isDragging = true;

		offsetX = e.clientX - stickerBox.offsetLeft;
		offsetY = e.clientY - stickerBox.offsetTop;
		stickerBox.style.cursor = 'grabbing';
	});

	document.addEventListener("mousemove", (e) => {
		if (isDragging) {
			stickerBox.style.left = (e.clientX - offsetX) + 'px';
			stickerBox.style.top = (e.clientY - offsetY) + 'px';
		}
	});

	document.addEventListener("mouseup", (e) => {
		isDragging = false;
		stickerBox.style.cursor = 'move';
	});

    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.querySelector('.app-btn-save');
    const hiddenInput = document.getElementById('image_data');
	const form = document.getElementById('mainCaptureForm');

    captureButton.addEventListener('click', function(event) {
        event.preventDefault(); // Bloque le rechargement de la page

        // On donne au canvas la taille exacte de la vidéo
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // On dessine l'image vidéo sur le canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // On convertit le canvas en texte image (Base64)
        const imageData = canvas.toDataURL('image/png');

        // On injecte ce texte dans le champ caché
        hiddenInput.value = imageData;

        console.log("Shot taken : ", imageData.substring(0, 50) + "...");

		fetch('/studio/capture', {
			method: "POST",
			body: new FormData(form)
		});
		
    });
</script>