
const projet = document.querySelector('#projet');

document.querySelectorAll('.projet').forEach(function(projet) {
    projet.addEventListener('click', function() {
        document.querySelector('#projet').style.display = 'flex';
        const id = projet.dataset.id;
        const type = projet.dataset.type;
        showProject(id, type);
    });
});

document.querySelector('#projet').addEventListener('click', function(e) {
    if (e.target === document.querySelector('#projet')) {
        document.querySelector('#projet').style.display = 'none';
        document.querySelector('#projetInfos').innerHTML = '<div class="spinner-border" role="status"></div>';
    }
});


async function showProject(id, type){
    const response = await fetch(`/api/projects/${id}`);
    const project = await response.json();

    const div = document.createElement('div');
    div.id = 'projetInfos';
    div.innerHTML = '';
    projet.innerHTML = '';
    projet.appendChild(div);

    const titre = document.createElement('h2');
    const date_sortie = document.createElement('i');
    const image = document.createElement('img');
    const description = document.createElement('p');
    
    titre.textContent = project.title;
    date_sortie.textContent = new Date(project.releaseDate).toLocaleString('fr-FR', {year: 'numeric', month: 'long', day: 'numeric'});
    image.src = `/images/projects/logos/${project.imageName}`;
    description.innerHTML = project.description;

    
    div.appendChild(titre);
    div.appendChild(date_sortie);
    div.appendChild(document.createElement('hr'));
    div.appendChild(image);
    div.appendChild(description);

    const liens = document.createElement('div');
    liens.id = 'liens';
    div.appendChild(liens);
    project.projectLinks.map(async function(url) {
        const response = await fetch(`${url}`);
        const link = await response.json();
        const a = document.createElement('a');
        a.class = "plateforme";
        a.href = link.url;
        a.target = "_blank";
        a.textContent = link.url;
        liens.appendChild(a);

        const response2 = await fetch(`${link.platform}`);
        const platform = await response2.json();
        const img = document.createElement('img');
        img.src = `/images/logos/${platform.imageName}`;
        img.alt = platform.name;
        img.classList.add('plateforme');
        a.innerHTML = '';
        a.appendChild(img);


    });

    if (type === 'album') {
        const tracklist = document.createElement('ol');
        const album_url = project.album;
        const response = await fetch(`${album_url}`);
        const album = await response.json();
        const elements = await Promise.all(
        album.songs.map(async function(song_url) {
            const response = await fetch(`${song_url}`);
            const song_info = await response.json();
            const reponse2 = await fetch(`${song_info.song}`);
            const song = await reponse2.json();
            const li = document.createElement('li');
            if (song_info.version == undefined) {
                li.textContent = `${song.title} - ${Math.trunc(song_info.duration/60)}:${song_info.duration%60}`;
            } else {
                li.textContent = `${song.title} (${song_info.version}) - ${Math.trunc(song_info.duration/60)}:${song_info.duration%60}`;
            }
            return li;
        }));
        tracklist.append(...elements);
        div.appendChild(tracklist);
    }

    const date_modif = document.createElement('span');
    date_modif.textContent = "Dernière modification : " + new Date(project.updatedAt).toLocaleString('fr-FR', {year: 'numeric', month: 'long', day: 'numeric'});
    div.appendChild(date_modif);

}