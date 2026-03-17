const MODEL_URI = "/vendor/face-api/models";

const videoElement = document.getElementById('video');
const videoContainer = document.querySelector('.canvas-placeholder');

// Chargement des modèles
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URI),
    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URI),
    faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URI),
    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URI),
    faceapi.nets.ageGenderNet.loadFromUri(MODEL_URI)
])
    .then(() => {
        console.log("Models charged!");
    })
    .catch((err) => {
        console.log("Error charging models:", err);
    });

// Quand la vidéo commence à diffuser
videoElement.addEventListener("playing", () => {
    
    // on donne une vraie taille à la balise pour que l'IA puisse la lire
    videoElement.width = videoElement.videoWidth;
    videoElement.height = videoElement.videoHeight;

    // création du canvas
    const canvas = faceapi.createCanvasFromMedia(videoElement);
    canvas.willReadFrequently = true;

    // superposition exacte sur la vidéo
    canvas.style.position = 'absolute';
    canvas.style.top = '0';
    canvas.style.left = '0';

    videoContainer.appendChild(canvas);

    setInterval(async () => {
        // n récupère la taille affichée à l'écran
        const displaySize = { 
            width: videoElement.clientWidth, 
            height: videoElement.clientHeight 
        };
        
        // adapte le canvas à cette taille d'affichage
        faceapi.matchDimensions(canvas, displaySize);

        // détection
        const detections = await faceapi
            .detectAllFaces(videoElement, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()

        //redimensionne les résultat
        const DetectionsArray = faceapi.resizeResults(detections, displaySize);
        
        // Nettoyage et dessin
        canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
        detectionsDraw(canvas, DetectionsArray);
        
    }, 10);
});

function detectionsDraw(canvas, DetectionsArray) {
    //faceapi.draw.drawDetections(canvas, DetectionsArray);
    faceapi.draw.drawFaceLandmarks(canvas, DetectionsArray);

    DetectionsArray.forEach((detection) => {
        const box = detection.detection.box;
        const drawBox = new faceapi.draw.DrawBox(box, {
            label: `${Math.round(detection.age)}y, ${detection.gender}`,
        });
        drawBox.draw(canvas);
    });
}