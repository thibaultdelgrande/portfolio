import "./app.css";
import { showProject } from "./projectLoader.js" ;

document.querySelectorAll('.projet').forEach(function (projet) {
    projet.addEventListener('click', function () {
        document.querySelector('#projet').style.display = 'flex';
        const id = projet.dataset.id;
        const type = projet.dataset.type;
        showProject(id, type);
    });
});

document.querySelector('#projet').addEventListener('click', function (e) {
    if (e.target === document.querySelector('#projet')) {
        document.querySelector('#projet').style.display = 'none';
        document.querySelector('#projetInfos').innerHTML = '<div class="spinner-border" role="status"></div>';
    }
});