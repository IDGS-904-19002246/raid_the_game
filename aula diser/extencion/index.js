console.log('ejecutando . . .');

// -------------------------------------------------------
var items = document.querySelectorAll('.list-row.js-list-row.js-pager-list-item__1');

items.forEach(item => {
    // console.log(item);
    const lead_link = item.getElementsByClassName('js-navigate-link');
    const simple_text = $(item).find('.block-selectable');

    const event = (simple_text[3].textContent).replaceAll('\n','').trim();
    // const values = GetValues(event, $(item));

    const row = {
        fecha: GetDate((simple_text[0].textContent).replaceAll('\n','').trim()),
        usuario: (simple_text[1].textContent).replaceAll('\n','').trim(),
        objeto: (lead_link[0].textContent).replaceAll('\n','').trim(),
        url: (lead_link[0].href).replaceAll('\n','').trim(),
        nombre: (simple_text[2].textContent).replaceAll('\n','').trim(),
        evento: event.replaceAll('"',"'")

        // valor_ante: values.ante.trim(),
        // valor_post: values.post.trim()
    };
    // console.log(  JSON.stringify(row) );
    save(JSON.stringify(row));
    // console.log(GetDate((simple_text[0].textContent).replaceAll('\n','').trim()));
});

function GetValues(event, list) {
    var values = [];
    switch (event) {
        case 'Etiquetas agregadas':
            const select_value = list.find('.event-tag');
            values = {
                ante: '',
                post: select_value.text()
            };
            break;
        case 'La etapa de ventas cambiada':
            const pipe = list.find('.node-lead__pipe-text');
            const status = list.find('.note-lead__status-text');
            values = {
                ante: `${pipe[0].textContent} ${status[0].textContent}`,
                post: `${pipe[1].textContent} ${status[1].textContent}`
            };
            break;
            
        default:
            const values_list = list.find('.event-field-value .block-selectable');
            
            console.log(values_list);

            if(values_list.length >= 2){
                // values = {
                //     ante: values_list[0].textContent,
                //     post: values_list[1].textContent
                // }
                values = {
                    ante: '',
                    post: ''
                }
            }
            break;
    }
    return values;
}

function GetDate(text){
    const [fecha, hora] = text.split(" ");
    const [dia, mes, anio] = fecha.split("/").map(Number);
    const [horas, minutos] = hora.split(":").map(Number);
    // const fechaDatetime = new Date(anio, mes - 1, dia, horas, minutos);
    
    return `${anio}/${String(mes).padStart(2, '0')}/${String(dia).padStart(2, '0')} ${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:00`;
}

function save(json) {
    fetch('https://wh.auladiser.work/db_kommo.php', {
        method: 'GET'
        // ,
        // headers: {
        //     'Content-Type': 'application/json'
        // },
        // body: JSON.stringify(json)
    })
    .then(response => {
        console.log(response);
    })
        
    

    // .then(data => {

    //     console.log(data);

    // }).catch(error => console.error('Error:', error));


    // <script>
    //     document.getElementById('dataForm').addEventListener('submit', function(event) {
    //         event.preventDefault();

    //         const name = document.getElementById('name').value;
    //         const age = document.getElementById('age').value;

    //         const data = {
    //             name: name,
    //             age: age
    //         };

    //         fetch('process.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify(data)
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             const responseDiv = document.getElementById('response');
    //             responseDiv.innerHTML = '<h2>Datos recibidos:</h2><ul>' +
    //                 data.map(item => `<li>${item.name} - ${item.age}</li>`).join('') +
    //                 '</ul>';
    //         })
    //         .catch(error => console.error('Error:', error));
    //     });
    // </script>
}