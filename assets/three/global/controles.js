// controls.js
import PlayerMove from "./mouvement";

export default class PlayerControls {
    /**
     * Permet de définir les contrôles du joueur en fonction de l'appareil utilisé (clavier, manette ou tactile)
     */
    constructor(modeJeu) {
        this.modeJeu = modeJeu; // Mode de jeu (fps, 2d, vr)
        this.tactile = false; // Désactive le tactile par défaut

        this.moveUp = false;
        this.moveDown = false;
        this.moveLeft = false;
        this.moveRight = false;
        this.canJump = false;

        this.playerMove = new PlayerMove();

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
        // Met à jour les contrôles
        this.update();
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
                    this.moveUp = true;
                    break;
                case 'ArrowDown':
                case 'KeyS':
                    this.moveDown = true;
                    break;
                case 'ArrowLeft':
                case 'KeyA':
                    this.moveLeft = true;
                    break;
                case 'ArrowRight':
                case 'KeyD':
                    this.moveRight = true;
                    break;
                case 'Space':
                    this.canJump = true;
                    break;
            }
        });
        window.addEventListener('keyup', (event) => {
            switch (event.code) {
                case 'ArrowUp':
                case 'KeyW':
                    this.moveUp = false;
                    break;
                case 'ArrowDown':
                case 'KeyS':
                    this.moveDown = false;
                    break;
                case 'ArrowLeft':
                case 'KeyA':
                    this.moveLeft = false;
                    break;
                case 'ArrowRight':
                case 'KeyD':
                    this.moveRight = false;
                    break;
                case 'Space':
                    this.canJump = false;
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

    /**
     * Mets à jour les contrôles
     */
    update() {
        if (this.moveUp) {
            console.log('up')
        }
        if (this.moveDown) {
            console.log('down')
        }
        if (this.moveLeft) {
            console.log('left')
        }
        if (this.moveRight) {
            console.log('right')
        }
        if (this.canJump) {
            console.log('jump')
        }
        requestAnimationFrame(() => this.update());
    }
}
