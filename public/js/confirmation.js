console.log('Script chargé ! confirmJS');
document.addEventListener("DOMContentLoaded", function() {
    let deleteButtons = document.querySelectorAll('.btn-danger');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Bouton Supprimer cliqué !');
            let appointmentId = this.getAttribute('data-id');
            event.preventDefault();

            if(!confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')) return;
            document.getElementById('delete-form-' + appointmentId).submit();

        });
    });
});
