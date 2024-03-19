import * as THREE from 'three';

export default class Text3D extends THREE.Sprite {
    constructor(text, fontSize = 32, color = 'rgba(0, 0, 0, 1)') {
        super();
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d', { antialias: true }); // Activer l'antialiasing
        const devicePixelRatio = window.devicePixelRatio || 1;
        const scale = devicePixelRatio*8; // Ajuster l'échelle en fonction du device pixel ratio
        const font = `Bold ${fontSize * scale}px Ubuntu`;

        document.fonts.ready.then(() => {
            // Code to execute after the font has loaded
            context.font = font;
            context.fillStyle = color;
            const maxWidth = context.measureText(text).width; // Définir la largeur maximale en fonction de la largeur du texte
            const lineHeight = fontSize * scale * 1.2; // Ajuster la hauteur de ligne en fonction de la taille de la police et de l'échelle
            canvas.width = maxWidth * scale;
            canvas.height = lineHeight;
            context.font = font; // Définir à nouveau la police après avoir ajusté la taille du canvas
            context.fillStyle = color;
            context.textBaseline = 'middle'; // Aligner le texte verticalement au milieu
            const lines = text.split('\n');
            const totalHeight = lines.length * lineHeight;
            lines.forEach((line, index) => {
            const x = (canvas.width - context.measureText(line).width) / 2; // Centrer le texte horizontalement
            const y = (index + 0.5) * lineHeight; // Calculer la position y en fonction de l'index de la ligne
            context.fillText(line, x, y);
            });
            const texture = new THREE.CanvasTexture(canvas);
            texture.needsUpdate = true;
            const spriteMaterial = new THREE.SpriteMaterial({ map: texture });
            this.material = spriteMaterial;
            this.scale.set(maxWidth, totalHeight/8, 1);
            this.canvas = canvas;
        }); // Ajuster la taille de la police en fonction de l'échelle
    }
}