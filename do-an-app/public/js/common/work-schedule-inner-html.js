export function addRowTr(employees) {
    return `
        <tr>
            <td class="td-table-input">
                <input name="time_slot[]"
                    style="text-align: right !important;"
                    type="text"
                    value="00:00"
                    class="form-control input-in-table datetimepicker-input" />
            </td>
            <td class="td-table-input">
                <select name="is_selected[]" class="form-control select-appearance nice-select sort-select input-in-table select-option-one">
                    <option value="1">Cho phép chọn</option>
                    <option value="0">Không được chọn</option>
                </select>
            </td>
            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%" class="btn btn-danger btn-sm btn-delete-working-schedule" data-workingscheduleid="null">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `
}
export function addRowTrTwo(hours) {
    return hours.map(hour => {
        return `
        <tr>
            <td class="td-table-input">
                <input name="time_slot[]"
                        style="text-align: right !important;" type="text"
                        class="form-control input-in-table datetimepicker-input"
                        value="${hour.time_slot}"
                />
            </td>
            <td class="td-table-input">
                <select name="is_selected[]" class="form-control select-appearance nice-select sort-select input-in-table ${hour.is_selected == 0 ? 'select-option-tow' : 'select-option-one'}">
                    <option value="1" ${hour.is_selected == 1? 'selected' : ''}>Cho phép chọn</option>
                    <option value="0" ${hour.is_selected == 0? 'selected' : ''}>Không được chọn</option>
                </select>
            </td>

            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%"
                        class="btn btn-danger btn-sm btn-delete-working-schedule" data-workingscheduleid="null">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `
    }).join('')
}


export function emptyRowTr() {
    return `
        <tr id="emptyTr">
            <td colspan="5">Không có lịch làm việc gần đây</td>
        </tr>
    `
}
