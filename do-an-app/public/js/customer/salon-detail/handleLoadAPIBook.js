
export function isSelected(isSelect) {
    return isSelect == 1 ? 'button-working-date-value' : 'button-working-date-no-select';
}
export function emptyDateSlot() {
    return `
        <button class="button-working-date-value-empty">Không có khung giờ nào gần đây</button>
    `;
}

export function emptyEmployee() {
    return `
        <div class="employee-item-empty">
            <p>Không tìm thấy nhân viên nào ⚠️</p>
        </div>
    `;
}
export function loadWordDate(workDate, salonId) {
    $.ajax({
        type: 'GET',
        url: `/lam-dep/${salonId}/dat-lich/ngay-lam-viec?date=${workDate}`,
        success: function (resp) {
           if(resp?.success) {
               if(resp.data) {
                   let hours = resp.data.hours;
                   let newHTML = hours.map(hour => {
                       return `
                        <button class="${isSelected(hour.is_selected)}">${hour.time_slot}</button>
                    `
                   }).join('')
                   $('#lWorkingDate').html(newHTML)
               } else {
                   $('#lWorkingDate').html(emptyDateSlot())
               }

           } else {
               Swal.fire({
                   icon: 'error',
                   title: 'Đã bị lỗi trong quá trình load dữ liệu',
               })
               $('#lWorkingDate').html(emptyDateSlot())
           }
        },
        error: function (err) {
            Swal.fire({
                icon: 'error',
                title: 'Đã bị lỗi trong quá trình load dữ liệu',
            })
            console.log(err)
            $('#lWorkingDate').html(emptyDateSlot())
        }
    });
}

export function loadEmployeeWord(timeSlot,workDate, salonId) {
    $.ajax({
        type: 'GET',
        url: `/lam-dep/${salonId}/dat-lich/nhan-vien-lam-viec?time_slot=${timeSlot}&date_working=${workDate}&salon_id=${salonId}`,
        success: function (resp) {
            if(resp?.success) {
                if(resp.data.length > 0) {
                    let newHTML = resp.data.map(employee => {
                        return `
                            <div class="employee-item">
                              <img src="/media/employee/${employee.image}" alt=""/>
                              <p class="employee-name">${employee.fullname}</p>
                              <p class="employee-description">${employee.description}</p>
                              <div class="employee-container-button">
                                 <button class="button-employee-value" data-employee-id="${employee.employee_id}">Chọn</button>
                              </div>
                            </div>
                        `
                    }).join('')
                    $('#lEmployee').html(newHTML)
                } else {
                    $('#lEmployee').html(emptyEmployee())
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Đã bị lỗi trong quá trình load dữ liệu',
                })
                $('#lEmployee').html(emptyEmployee())
            }
        },
        error: function (err) {
            Swal.fire({
                icon: 'error',
                title: 'Đã bị lỗi trong quá trình load dữ liệu',
            })
            $('#lEmployee').html(emptyEmployee())
        }
    });
}

