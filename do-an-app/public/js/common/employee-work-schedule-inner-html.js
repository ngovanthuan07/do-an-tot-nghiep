export function addRowTr(employees) {
    return `
        <tr>
            <td style="display: none"><input type="hidden" name="ews_ids[]" ></td>
<!--            <td class="td-table-input text-right"><span class="mr-3"></span></td>-->
            <td class="td-table-input">
                <select name="employee_id[]" class="form-control select-appearance nice-select sort-select input-in-table">
                    <option value="">Chọn nhân viên</option>
                    ${
                        employees.map(employee => (
                            `
                                <option value="${employee.employee_id}">${employee.fullname} | ${employee.employee_id}</option>
                            `
                        ))
                     }
                </select>
            </td>
            <td class="td-table-input">
                <input name="start_time[]"
                    style="text-align: right !important;"
                    type="text"
                    value="7:00"
                    class="form-control input-in-table datetimepicker-input" />
            </td>
            <td class="td-table-input">
                <input name="end_time[]"
                    style="text-align: right !important;"
                    type="text"
                    value="15:00"
                    class="form-control input-in-table datetimepicker-input"/>
            </td>
            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%" class="btn btn-danger btn-sm btn-delete-working-schedule" data-workingscheduleid="null">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `
}
export function addRowTrTwo(works, employees) {
    return works.map(work => {
        return `
        <tr>
            <td style="display: none"><input type="hidden" name="ews_ids[]" value="${work.ews_id}"></td>
<!--            <td class="td-table-input text-right"><span class="mr-3"></span></td>-->
            <td class="td-table-input">
                <select name="employee_id[]" class="form-control select-appearance nice-select sort-select input-in-table">
                    <option value="">Chọn nhân viên</option>
                    ${
                        employees.map(employee => (`
                                <option value="${employee.employee_id}"
                                               ${work.employee_id === employee.employee_id ? 'selected' : '' }>
                                    ${employee.fullname} | ${employee.employee_id}
                                </option>
                            `
                        ))
                    }
                </select>
            </td>
            <td class="td-table-input">
                <input name="start_time[]"
                        style="text-align: right !important;" type="text"
                        class="form-control input-in-table datetimepicker-input"
                        value="${work.start_time}"
                />
            </td>
            <td class="td-table-input">
                <input name="end_time[]"
                        style="text-align: right !important;" type="text"
                        class="form-control input-in-table datetimepicker-input"
                        value="${work.end_time}"
                />
            </td>
            <td style="padding: 0px; text-align: center;">
                <button style="margin-top: 3%"
                        class="btn btn-danger btn-sm btn-delete-working-schedule" data-workingscheduleid="${work.ews_id}">
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
