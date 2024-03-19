import './app.css';
import * as THREE from 'three';
import PlayerControls from './global/controles';
import Text3D from './global/text';
import GUI from 'lil-gui';
import { showProject } from '../projectLoader.js';


const proprietes = {
	jumpHeight: 500,
	vitesse: 2000,
	appareil: 'clavier',
	modeJeu: 'fps'
}
/**
 * GUI
 */
let guiVisible



const gui = new GUI();
gui.add(proprietes, 'modeJeu', ['fps']).onChange((value) => {
	proprietes.modeJeu = value;
});

if (import.meta.env.DEV) {
	guiVisible = true;
}
else {
	guiVisible = false;
	gui.domElement.style.display = 'none';
}



document.addEventListener('keydown', (event) => {
	if (event.key === '²') {
		guiVisible = !guiVisible;
		gui.domElement.style.display = guiVisible ? 'block' : 'none';
	}
});






let camera, scene, renderer;
const objects = [];

let raycaster;

let intersectedObject = null;

init();
animate();

function init() {

	camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
	camera.position.y = 20;

	scene = new THREE.Scene();
	scene.background = new THREE.Color(0xffffff);


	raycaster = new THREE.Raycaster(new THREE.Vector3(), new THREE.Vector3(0, - 1, 0), 0, 10);


	// PlayerControls

	const playerControls = new PlayerControls(proprietes.modeJeu, camera, raycaster, proprietes, scene);
	scene.add(playerControls.playerMove.controls.getObject())

	// floor

	let floorGeometry = new THREE.PlaneGeometry(10000, 600);
	floorGeometry.rotateX(- Math.PI / 2);


	const floorMaterial = new THREE.MeshBasicMaterial({ color: 0xffafcc });

	const floor = new THREE.Mesh(floorGeometry, floorMaterial);
	floor.position.z = -200;
	scene.add(floor);

	// Textes

	const gameText = new Text3D('Jeux');
	gameText.position.set(-100, 20, -200);
	scene.add(gameText);

	const musicText = new Text3D('Musique');
	musicText.position.set(100, 20, -200);
	scene.add(musicText);

	const siteText = new Text3D('Site web');
	siteText.position.set(-100, 20, -400);
	scene.add(siteText);

	const videoText = new Text3D('Vidéos');
	videoText.position.set(100, 20, -400);
	scene.add(videoText);

	// Afficher les jaquettes

	const url = '/api/projects';
	let compteurJeux = 0;
	let compteurMusique = 0;
	let compteurSite = 0;
	let compteurVideo = 0;

	fetch(url)
		.then(response => response.json())
		.then(data => {
			data["hydra:member"].forEach((element, index) => {
				let positionX = 0;
				let positionZ = 0;

				switch (element.type) {
					case 'game':
						positionX = -300 - (compteurJeux * 200);
						positionZ = -200;
						compteurJeux++;
						break;
					case 'album':
						positionX = 300 + (compteurMusique * 200);
						positionZ = -200;
						compteurMusique++;
						break;
					case 'website':
						positionX = -300 - (compteurSite * 200);
						positionZ = -400;
						compteurSite++;
						break;
					case 'video':
						positionX = 300 + (compteurVideo * 200);
						positionZ = -400;
						compteurVideo++;
						break;
				}

				// Ajoute le titre du projet
				const titre = new Text3D(element.title, 12);
				titre.position.set(positionX, 110, positionZ + 10);
				scene.add(titre);

				const img = new Image();

				img.onload = function () {
					const height = img.height;
					const width = img.width;
					const ratio = width / height;

					const jaquette = new THREE.TextureLoader().load(`/images/projects/logos/${element.imageName}`);
					const jaquetteMaterial = new THREE.SpriteMaterial({ map: jaquette });
					const jaquetteMesh = new THREE.Sprite(jaquetteMaterial);
					jaquetteMesh.scale.set(100 * ratio, 100, 1);
					jaquetteMesh.position.set(positionX, 50, positionZ);
					jaquetteMesh.name = element.id;
					jaquetteMesh.type = element.type;
					scene.add(jaquetteMesh);
					objects.push(jaquetteMesh);
				};

				img.src = `/images/projects/logos/${element.imageName}`;

			});
		});


	//

	renderer = new THREE.WebGLRenderer({ antialias: true });
	renderer.setPixelRatio(window.devicePixelRatio);
	renderer.setSize(window.innerWidth, window.innerHeight);
	document.body.appendChild(renderer.domElement);

	// Dans la fonction où vous effectuez le rendu de la scène
	function onDocumentMouseMove(event) {
		// Calculer la position du point de vue du joueur
		const vector = new THREE.Vector3();
		vector.set(
			// La position du point de vue du joueur sur l'axe x
			0,
			// La position du point de vue du joueur sur l'axe y
			0,
			0
		);
		vector.unproject(camera);

		// Créer un rayon à partir de la caméra dans la direction du point de vue du joueur
		const raycaster = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());

		raycaster.camera = camera;

		// Vérifier les intersections avec les objets de la scène
		const intersects = raycaster.intersectObjects(objects);

		// Si des intersections sont trouvées
		if (intersects.length > 0) {
			// Récupérer l'objet le plus proche
			intersectedObject = intersects[0].object;
		}
		else {
			intersectedObject = null;
		}
	}


	// Ajouter un écouteur d'événements pour détecter les mouvements de la souris

	document.addEventListener('mousemove', onDocumentMouseMove, false);

	document.addEventListener('click', () => {
		if (intersectedObject !== null && playerControls.playerMove.controls.isLocked) {

			// Afficher #projet
			document.getElementById('projet').style.display = 'flex';

			// Bloquer les mouvements du joueur
			playerControls.playerMove.unlock();

			showProject(intersectedObject.name, intersectedObject.type);
		}
	});
	//

	document.getElementById('projet').addEventListener('click', function (e) {
		if (e.target === document.getElementById('projet')) {
			document.getElementById('projet').style.display = 'none';
			document.getElementById('projetInfos').innerHTML = '<div class="spinner-border" role="status"></div>';
			playerControls.playerMove.lock();
		}
	}
	);

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			document.getElementById('projet').style.display = 'none';
			document.getElementById('projetInfos').innerHTML = '<div class="spinner-border" role="status"></div>';
			playerControls.playerMove.lock();
		}
	});


	window.addEventListener('resize', onWindowResize);
}

function onWindowResize() {

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize(window.innerWidth, window.innerHeight);

}

function animate() {
	requestAnimationFrame(animate);
	renderer.render(scene, camera);
}