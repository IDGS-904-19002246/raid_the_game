$(document).ready(function() {
    $('#miTabla').DataTable();
});
// FORMULARIO ------------------------------------------------------------
// var form = $('#insert')[0];
// form.addEventListener('submit', function(event) { 
//     event.preventDefault();
//     console.log('enviando form');
    
//     var formData = new FormData(this);
//     console.log(formData);
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', 'https://expertosraid.com/juego/puntajes/index.php', true);
//     xhr.onreadystatechange = function() {
//        console.log('onreadystatechange');
//        if (xhr.readyState === XMLHttpRequest.DONE) {
//            console.log('DONE');
//            if (xhr.status === 200) {
//                if (xhr.responseText == '1') {
//                    Swal.fire({icon: 'success',title: 'Datos guardados correctamente',showConfirmButton: false});
//                    xhr.send(formData);
//                }else{
//                    Swal.fire({icon: 'error',title: 'Este ticket ya se encuentra registrado',showConfirmButton: false});
//                }

//            } else {
//                console.error('Hubo un error con el formulario');
//            }
//        }
//     }
// });

// INPUT IMAGEN -------------------------------------------------------------
document.getElementById('fileClear').addEventListener('click', function(btn) {
    clear();
});
document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {

        $('#fileClear').removeClass('d-none');

        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});
// FORMULARIOS -------------------------------------------------------------
// const btnAlert = document.querySelectorAll('.btn-to-alert');
// const btnModalInsert = $('#to_insert')[0];
// btnModalInsert.addEventListener('click', () => {
//     $('#insert')[0].reset();

//     clear();

// });

// function clear() {
//     $('#fileClear').addClass('d-none');

//     const imagePreview = document.getElementById('imagePreview');
//     imagePreview.src = '#';
//     imagePreview.classList.add('d-none');

//     const fileInput = document.getElementById('fileInput');
//     fileInput.value = '';
// }
// btnAlert.forEach(btn => {
//     btn.addEventListener('click', () => {
//         const object = btn.getAttribute('data-to-modal');
//         const json = JSON.parse(object);
//         const my_alert = $('#my_alert');

//         my_alert.find('#name').text(json.user_name);
//         my_alert.find('#email').text(json.email);
//         my_alert.find('#telephone').text(json.telephone);
//         my_alert.find('#city').text(json.city);
//         my_alert.find('#state').text(json.state);
//         my_alert.find('#ticket').text(json.ticket);
//         my_alert.find('#score').text(json.score);
//         my_alert.find('#establishment').text(json.establishment);
//         my_alert.find('#photo').prop("src",
//             `https://expertosraid.com/juego/puntajes/assets/tickets_fotos/${json.photo}`);
//     });
// });