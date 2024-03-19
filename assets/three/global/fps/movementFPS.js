import PlayerMove from '../mouvement.js';
import { PointerLockControls } from 'three/addons/controls/PointerLockControls.js';

export default class PlayerFPS extends PlayerMove {
    constructor(camera, raycaster, proprietes) {
        super(camera, raycaster, proprietes);

        const projet = document.getElementById('projet');

        this.controls = new PointerLockControls(this.camera, document.body);

        this.blocker = document.getElementById('blocker');
        this.instructions = document.getElementById('instructions');

        this.instructions.addEventListener('click', () => {

            this.controls.lock();

        });

        this.controls.addEventListener('lock', () => {
            this.instructions.style.display = 'none';
            this.blocker.style.display = 'none';
        });

        this.controls.addEventListener('unlock', () => {
            if (projet.style.display === 'none') {
                this.blocker.style.display = 'block';
                this.instructions.style.display = '';
            }
        }
        );

        this.prevTime = performance.now();

        this.update();
    }



    update() {
        const time = performance.now();
        if (this.controls.isLocked) {
            this.raycaster.ray.origin.copy(this.controls.getObject().position);
            this.raycaster.ray.origin.y -= 10;

            // const intersections = this.raycaster.intersectObjects(collisionsObjects, false);

            // const onObject = intersections.length > 0;

            const delta = (time - this.prevTime) / 1000;

            this.velocity.x -= this.velocity.x * 10.0 * delta;
            this.velocity.z -= this.velocity.z * 10.0 * delta;

            this.velocity.y -= 9.8 * 100.0 * delta; // 100.0 = mass

            this.direction.z = Number(this.up) - Number(this.down);
            this.direction.x = Number(this.right) - Number(this.left);
            this.direction.normalize(); // this ensures consistent movements in all directions


            if (this.up || this.down) this.velocity.z -= this.direction.z * this.proprietes.vitesse * delta;
            if (this.left || this.right) this.velocity.x -= this.direction.x * this.proprietes.vitesse * delta;

            /*if (onObject === true) {

                this.velocity.y = Math.max(0, this.velocity.y);
                this.jump = true;

            }*/

            this.controls.moveRight(- this.velocity.x * delta);
            this.controls.moveForward(- this.velocity.z * delta);

            this.controls.getObject().position.y += (this.velocity.y * delta); // new behavior

            if (this.controls.getObject().position.y < 60) {

                this.velocity.y = 0;
                this.controls.getObject().position.y = 60;

                this.jump = true;
            }
        }

        this.prevTime = time;

        requestAnimationFrame(() => this.update());
    }

    unlock() {
        this.controls.unlock();
    }

    lock() {
        this.controls.lock();
    }
}