window.onload = () => {
    let elementCalendrier = document.getElementById("calendrier");

    if (!elementCalendrier) {
        console.error("L'élément #calendrier n'existe pas.");
        return;
    }

    // on instancie le calendrier
    let calendrier = new FullCalendar.Calendar(elementCalendrier, {
        plugins: ['dayGrid' , 'timeGrid' ],
        defaultView: 'timeGridWeek',
        locale: 'fr',
        header:{
            left: 'prev, next today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, list'
        },
        buttonText:{
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
        }
    });

    calendrier.render();
};
