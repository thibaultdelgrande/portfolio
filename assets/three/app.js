import * as THREE from 'three';
import { PointerLockControls } from 'three/addons/controls/PointerLockControls.js';
import './app.css';
import GUI from 'lil-gui';
import PlayerControls from './global/controles';
import Text3D from './global/text';
import { FontLoader } from 'three/addons/loaders/FontLoader.js';
import { TextGeometry } from 'three/addons/geometries/TextGeometry.js';



/**
 * GUI
 */

const gui = new GUI()

const proprietes = {
	jumpHeight: 500,
	vitesse: 2000,
	appareil: 'clavier',
	modeJeu: 'fps'
}

gui.add(proprietes, 'jumpHeight', 0, 500).onChange((value) => {
	proprietes.jumpHeight = value;
});
gui.add(proprietes, 'vitesse', 0, 1000).onChange((value) => {
	proprietes.vitesse = value;
});
gui.add(proprietes, 'modeJeu', ['fps', '2d', 'vr']).onChange((value) => {
	proprietes.modeJeu = value;
});




let camera, scene, renderer, controls;

const objects = [];

let raycaster;

let moveForward = false;
let moveBackward = false;
let moveLeft = false;
let moveRight = false;
let canJump = false;

let prevTime = performance.now();
const velocity = new THREE.Vector3();
const direction = new THREE.Vector3();

// PlayerControls
const playerControls = new PlayerControls(proprietes.modeJeu);
init();
animate();

function init() {

	camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
	camera.position.y = 20;

	scene = new THREE.Scene();
	scene.background = new THREE.Color(0xffffff);
	scene.fog = new THREE.Fog(0xffffff, 0, 750);


	controls = new PointerLockControls(camera, document.body);

	const blocker = document.getElementById('blocker');
	const instructions = document.getElementById('instructions');

	instructions.addEventListener('click', function () {

		controls.lock();

	});

	controls.addEventListener('lock', function () {

		instructions.style.display = 'none';
		blocker.style.display = 'none';

	});

	controls.addEventListener('unlock', function () {
		blocker.style.display = 'block';
		instructions.style.display = '';

	});

	scene.add(controls.getObject());

	const onKeyDown = function (event) {

		switch (event.code) {
			case 'ArrowUp':
			case 'KeyW':
				moveForward = true;
				break;

			case 'ArrowLeft':
			case 'KeyA':
				moveLeft = true;
				break;

			case 'ArrowDown':
			case 'KeyS':
				moveBackward = true;
				break;

			case 'ArrowRight':
			case 'KeyD':
				moveRight = true;
				break;

			case 'Space':
				if (canJump === true) velocity.y += proprietes.jumpHeight;
				canJump = false;
				break;

		}

	};

	const onKeyUp = function (event) {

		switch (event.code) {

			case 'ArrowUp':
			case 'KeyW':
				moveForward = false;
				break;

			case 'ArrowLeft':
			case 'KeyA':
				moveLeft = false;
				break;

			case 'ArrowDown':
			case 'KeyS':
				moveBackward = false;
				break;

			case 'ArrowRight':
			case 'KeyD':
				moveRight = false;
				break;

		}

	};

	document.addEventListener('keydown', onKeyDown);
	document.addEventListener('keyup', onKeyUp);

	raycaster = new THREE.Raycaster(new THREE.Vector3(), new THREE.Vector3(0, - 1, 0), 0, 10);

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
						console.log(compteurMusique, element.type, positionX, positionZ)
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
				
				console.log(positionX, positionZ,element.type)


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

	const time = performance.now();

	if (controls.isLocked === true) {

		raycaster.ray.origin.copy(controls.getObject().position);
		raycaster.ray.origin.y -= 10;

		const intersections = raycaster.intersectObjects(objects, false);

		const onObject = intersections.length > 0;

		const delta = (time - prevTime) / 1000;

		velocity.x -= velocity.x * 10.0 * delta;
		velocity.z -= velocity.z * 10.0 * delta;

		velocity.y -= 9.8 * 100.0 * delta; // 100.0 = mass

		direction.z = Number(moveForward) - Number(moveBackward);
		direction.x = Number(moveRight) - Number(moveLeft);
		direction.normalize(); // this ensures consistent movements in all directions


		if (moveForward || moveBackward) velocity.z -= direction.z * proprietes.vitesse * delta;
		if (moveLeft || moveRight) velocity.x -= direction.x * proprietes.vitesse * delta;

		if (onObject === true) {

			velocity.y = Math.max(0, velocity.y);
			canJump = true;

		}

		controls.moveRight(- velocity.x * delta);
		controls.moveForward(- velocity.z * delta);

		controls.getObject().position.y += (velocity.y * delta); // new behavior

		if (controls.getObject().position.y < 20) {

			velocity.y = 0;
			controls.getObject().position.y = 20;

			canJump = true;
		}

	}

	prevTime = time;

	renderer.render(scene, camera);

}