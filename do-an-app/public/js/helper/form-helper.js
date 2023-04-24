export function serializeFormToObject(formId) {
    let form = $('#' + formId); // Lấy form theo id bằng jQuery
    let serializedArray = form.serializeArray(); // Sử dụng serializeArray để serialize form thành một mảng các đối tượng {name, value}
    let serializedData = {}; // Khởi tạo object kết quả là một object rỗng
    // Lặp qua mảng serializedArray và gán giá trị vào object kết quả
    $.each(serializedArray, function(index, field) {
        serializedData = {...serializedData, [field.name]: field.value};
    });

    return serializedData;
}


export function serializeFormToFormData(formId) {
    let form = $('#' + formId);
    let serializedArray = form.serializeArray();

    let formData = new FormData();

    $.each(serializedArray, function(index, field) {
        formData.append(field.name, field.value);
    });

    return formData;
}

export function logFormData(formData) {
    console.log(Object.fromEntries(formData.entries()))
}
