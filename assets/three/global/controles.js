// controls.js
import PlayerFPS from "./fps/movementFPS";

export default class PlayerControls {
    /**
     * Permet de définir les contrôles du joueur en fonction de l'appareil utilisé (clavier, manette ou tactile)
     */
    constructor(modeJeu,camera,raycaster, proprietes) {
        this.tactile = false; // Désactive le tactile par défaut

        this.moveUp = false;
        this.moveDown = false;
        this.moveLeft = false;
        this.moveRight = false;
        this.canJump = false;
        this.camera = camera;
        this.raycaster = raycaster;
        this.proprietes = proprietes

        if (modeJeu == "fps") {
            this.playerMove = new PlayerFPS(camera,raycaster,this.proprietes);
        }

        // Si l'utilisateur touche l'écran, active le tactile
        window.addEventListener('touchstart', () => {
            if (this.tactile) return;
            this.tactile = true;
            // Créer les boutons de contrôle tactile
            this.createTouchControls();
            // Désactiver le zoom
        });
        // Contrôles au clavier
        this.clavier();
        // Contrôles à la manette
        this.manette();
    }

    /**
     * Créer les boutons de contrôle tactile
     */
    createTouchControls() {
    }

    /**
     * Contrôles au clavier
     */
    clavier() {
        // Déplacement
        window.addEventListener('keydown', (event) => {
            switch (event.code) {
                case 'ArrowUp':
                case 'KeyW':
                    this.playerMove.up = true;
                    break;
                case 'ArrowDown':
                case 'KeyS':
                    this.playerMove.down = true;
                    break;
                case 'ArrowLeft':
                case 'KeyA':
                    this.playerMove.left = true;
                    break;
                case 'ArrowRight':
                case 'KeyD':
                    this.playerMove.right = true;
                    break;
                case 'Space':
                    if (this.playerMove.jump) this.playerMove.velocity.y += this.proprietes.jumpHeight;
                    this.playerMove.jump = false;
                    break;
            }
        });
        window.addEventListener('keyup', (event) => {
            switch (event.code) {
                case 'ArrowUp':
                case 'KeyW':
                    this.playerMove.up = false;
                    break;
                case 'ArrowDown':
                case 'KeyS':
                    this.playerMove.down = false;
                    break;
                case 'ArrowLeft':
                case 'KeyA':
                    this.playerMove.left = false;
                    break;
                case 'ArrowRight':
                case 'KeyD':
                    this.playerMove.right = false;
                    break;
            }
        });
    }

    /**
     * Contrôles à la manette
     */
    manette() {
        // Vérifie si une manette est connectée
    }
}
