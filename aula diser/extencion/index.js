console.log('ejecutando . . .');

var items = document.getElementsByClassName('list-row js-list-row js-pager-list-item__1');
console.log(`Tomando ${items.length} elementos`);
// console.log(items);


[...items].forEach(item => {
    const simple_text = item.getElementsByClassName('block-selectable');
    // const lead_link = item.getElementsByClassName('js-navigate-link');

    console.log(`
        ${simple_text[0].textContent} /
        ${simple_text[1].textContent} /
        ${simple_text[2].textContent} /
        ${simple_text[3].textContent} 
        `);
});

// items.forEach(item => {
//     const author = item.find('.list-row__cell-author');
//     console.log(author);
//     // console.log(item);
// });