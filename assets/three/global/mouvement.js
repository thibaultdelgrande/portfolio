import * as THREE from 'three';

export default class PlayerMove {
    constructor (camera,raycaster,proprietes) {
        this.camera = camera;
        this.raycaster = raycaster;
        this.proprietes = proprietes;
        this.velocity = new THREE.Vector3();
        this.direction = new THREE.Vector3();

        this.up = false;
        this.down = false;
        this.left = false;
        this.right = false;
        this.jump = false;
    }
}