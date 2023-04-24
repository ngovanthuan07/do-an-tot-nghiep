export function modalDispatch(type, action) {
    let modalID = '';
    switch (type) {
        case 'save': {
            modalID = '#confirmationModalSave';
            break;
        }
        case 'delete': {
            modalID = '#confirmationModalDelete';
            break;
        }
        case 'block': {
            modalID = '#confirmationModalBlock';
            break;
        }
    }
    if (action === 'show') {
        $(modalID).modal(action);
    } else {
        if (action === 'hide'){
            $(modalID).modal(action);
        }
    }
}

export function handleTypeButtonModal(type) {
    switch (type) {
        case 'save':
            return '#btnModalSave'
        case 'delete':
            return '#btnModalDelete'
        case 'block':
            return '#btnModalBlock'
    }
}

export function handleConfirmModal(callback, type) {
    let btn = handleTypeButtonModal(type)
    $(btn).on('click', function () {
        callback()
    })
}



