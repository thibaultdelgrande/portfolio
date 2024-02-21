import './app.css';
import * as THREE from 'three';
import PlayerControls from './global/controles';
import Text3D from './global/text';
import GUI from 'lil-gui';


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

if (import.meta.env.DEV) {
	guiVisible = true;
}
else {
	guiVisible = false;
}


const gui = new GUI();
gui.add(proprietes, 'modeJeu', ['fps']).onChange((value) => {
	proprietes.modeJeu = value;
});


document.addEventListener('keydown', (event) => {
	if (event.key === '²') {
		guiVisible = !guiVisible;
		gui.domElement.style.display = guiVisible ? 'block' : 'none';
	}
});






let camera, scene, renderer;
const objects = [];

let raycaster;

init();
animate();

function init() {

	camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
	camera.position.y = 20;

	scene = new THREE.Scene();
	scene.background = new THREE.Color(0xffffff);


	raycaster = new THREE.Raycaster(new THREE.Vector3(), new THREE.Vector3(0, - 1, 0), 0, 10);


	// PlayerControls

	const playerControls = new PlayerControls(proprietes.modeJeu, camera, raycaster, proprietes);
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
					scene.add(jaquetteMesh);
				};

				img.src = `/images/projects/logos/${element.imageName}`;

			});
		});




	//

	renderer = new THREE.WebGLRenderer({ antialias: true });
	renderer.setPixelRatio(window.devicePixelRatio);
	renderer.setSize(window.innerWidth, window.innerHeight);
	document.body.appendChild(renderer.domElement);

	//

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