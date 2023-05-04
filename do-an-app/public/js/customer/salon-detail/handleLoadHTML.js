import {loadingBallIndicatorChildHTML} from '/js/loading/loading-ball-indicator-child.js'
export function serviceEmptyLayout() {
    return `
         <div class="services-container-empty">
             <p> Không có dữ liệu</p>
          </div>
    `;
}
export function handleLoadingCategoryServicePage(html) {
    $('#list-services').html(html)
    $('#list-services').append(loadingBallIndicatorChildHTML())
    setTimeout(() => {
        $('.loading-ball-indicator-child').hide()
    }, 1000);
}
export function fetchCategoryService(salonID, categorySerID, serviceChooses) {
    $.ajax({
        type: "GET",
        url: `/lam-dep/get-service-by-category-service-and-salon-id?salon_id=${salonID}&cse_id=${categorySerID}`,
        dataType: "json",
        success: function (response) {
            if(Array.isArray(response)) {
                if(response.length > 0) {
                    let myHTML = response.map(service => {
                        return `
                            <div class="service-item">
                                <img src="/media/service/${service.image}" alt="${service.name}">
                                <div class="service-name">${service.name}</div>
                                <div class="service-description">
                                   ${service.description}
                                </div>
                                <div class="service-price">${service.price} đ</div>
                                <button class="service-select justify-content-center ${serviceChooses.includes(service.service_id) && 'active'}" data-service-id="${service.service_id}">
                                   Chọn
                                </button>
                            </div>
                        `;
                    }).join('');
                    handleLoadingCategoryServicePage(myHTML)
                } else {
                    handleLoadingCategoryServicePage(serviceEmptyLayout())
                }
            }
        },
        error: function (error) {
            console.log(error);
            toastr["error"]("Không thể load được dữ liệu!");
            handleLoadingCategoryServicePage(serviceEmptyLayout())
        }
    });
}

export function loadModalServices(services) {
    let myHTML = services.map(service => {
        return `
                           <tr class="fw-normal">
                            <th>
                                <img src="/media/service/${service.image}"
                                     class="shadow-1-strong rounded-circle" alt="avatar 1"
                                     style="width: 55px; height: auto;">
                            </th>
                            <td class="align-middle">
                                <span>${service.name}</span>
                            </td>
                            <td class="align-middle">
                                <h6 class="mb-0"><span class="badge bg-warning">${service.price}</span></h6>
                            </td>
                            <td class="align-middle">
                                <span class="service-table" style="cursor: pointer;" data-service-table-id="${service.service_id}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </span>
                            </td>
                        </tr>
                        `;
    }).join('');
    return myHTML;
}
