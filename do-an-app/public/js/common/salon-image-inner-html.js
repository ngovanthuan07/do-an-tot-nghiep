export function addRowTr(url, idImage) {
    return `
        <tr>
            <td class="td-table-input text-center">
                <img class="image-salon-pic" src="${url}" alt="">
            </td>
            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%" class="btn btn-danger btn-sm btn-delete-image" data-image-id="${idImage}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `
}
export function loadRowTr(images) {
    return images.map(image => {
        return `
        <tr>
            <td class="td-table-input text-center">
                <img class="image-salon-pic" src="/media/salon/${image.src}" alt="">
            </td>
            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%" class="btn btn-danger btn-sm btn-delete-image" data-image-id="${image.id}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `
    }).join('');

}
export function emptyRowTr() {
    return `
        <tr id="emptyTr">
            <td colspan="2">Không có hình ảnh gần đây</td>
        </tr>
    `
}
