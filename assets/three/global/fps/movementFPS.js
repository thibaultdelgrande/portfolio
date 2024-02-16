import '../mouvement.js'

export default class PlayerFPS {
    constructor () {
        this.controls = new PointerLockControls(camera, document.body);
    }
}