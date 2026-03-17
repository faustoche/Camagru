const MODEL_URI = "/vendor/face-api/models";

const videoElement = document.getElementById('video');
const videoContainer = document.querySelector('.canvas-placeholder');

// 1. Déclaration de l'image du filtre
const activeFilterImage = new Image();
// Vérifiez bien ce nom. Si votre fichier s'appelle dog.png, modifiez cette ligne.
activeFilterImage.src = '/stickers/dog_ears.png'; 

// 2. Chargement des modèles
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URI),
    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URI)
]).then(() => {
    console.log("Modèles IA prêts !");
}).catch((err) => {
    console.error("Erreur de chargement :", err);
});

// 3. Démarrage de la vidéo
videoElement.addEventListener("playing", () => {
    
    // On force les dimensions de la vidéo pour l'IA
    videoElement.width = videoElement.videoWidth;
    videoElement.height = videoElement.videoHeight;

    const canvas = faceapi.createCanvasFromMedia(videoElement);
    canvas.style.position = 'absolute';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.zIndex = '10';
    canvas.style.pointerEvents = 'none';

    videoContainer.appendChild(canvas);

    // 4. La boucle classique qui fonctionnait chez vous
    setInterval(async () => {
        const displaySize = { 
            width: videoElement.clientWidth, 
            height: videoElement.clientHeight 
        };
        faceapi.matchDimensions(canvas, displaySize);

        try {
            // Détection simple
            const detections = await faceapi
                .detectAllFaces(videoElement, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks();

            const context = canvas.getContext("2d");
            context.clearRect(0, 0, canvas.width, canvas.height);

            if (detections && detections.length > 0) {
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                
                // Pour chaque visage détecté
                resizedDetections.forEach(detection => {
                    const box = detection.detection.box;
                    
                    // Calcul de la taille et de la position
                    const filterWidth = box.width * 1.6; 
                    const ratio = activeFilterImage.naturalHeight / activeFilterImage.naturalWidth;
                    const filterHeight = filterWidth * ratio;

                    const x = box.x - (filterWidth - box.width) / 2;
                    const y = box.y - (filterHeight * 0.45);

                    // SÉCURITÉ : On vérifie que l'image existe bien avant de dessiner
                    if (activeFilterImage.complete && activeFilterImage.naturalWidth > 0) {
                        context.drawImage(activeFilterImage, x, y, filterWidth, filterHeight);
                    } else {
                        // Si l'image est introuvable, on dessine le carré vert pour alerter
                        faceapi.draw.drawDetections(canvas, [detection]);
                        console.warn("Impossible de charger l'image du filtre. Vérifiez le chemin.");
                    }
                });
            }
        } catch (e) {
            console.error("Erreur :", e);
        }
    }, 100);
});