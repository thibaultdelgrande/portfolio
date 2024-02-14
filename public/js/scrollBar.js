// L'objectif est de créer un bouton sur chaque côté des sélections qui sont des élements scrollable pour faire défiler les éléments

document.querySelectorAll('.categorie').forEach((el) => {
    let rightButton = el.querySelector('.right');
    let leftButton = el.querySelector('.left');


    /* Ajout de l'event listener */
    rightButton.addEventListener('click', () => {
        el.querySelector('.selection').scrollLeft += window.innerWidth;
        verifieSiAfficher(el);
    });

    leftButton.addEventListener('click', () => {
        el.querySelector('.selection').scrollLeft -= window.innerWidth;
        verifieSiAfficher(el);
    });

    el.querySelector('.selection').addEventListener('scroll', () => {
        verifieSiAfficher(el);
    }
    );

    verifieSiAfficher(el);
}
);

// Window resize
window.addEventListener('resize', () => {
    document.querySelectorAll('.categorie').forEach((el) => {
        verifieSiAfficher(el);
    });
});


function verifieSiAfficher(el) {
    // Vérifie si le bouton doit être affiché
    let rightButton = el.querySelector('.right');
    let leftButton = el.querySelector('.left');
    let selection = el.querySelector('.selection');

    // Si il n'y a pas de scroll
    if (selection.scrollWidth <= window.innerWidth) {
        rightButton.style.opacity = '0';
        leftButton.style.opacity = '0';
    }
    else {
        // Si on est au début
        if (selection.scrollLeft == 0) {
            leftButton.style.opacity = '0';
        }
        else {
            leftButton.style.opacity = '1';
        }

        // Si on est à la fin
        if (selection.scrollLeft + selection.clientWidth >= selection.scrollWidth) {
            rightButton.style.opacity = '0';
        }
        else {
            rightButton.style.opacity = '1';
        }
    }
}
