export function searchResult(salons) {
    let salonHtml = salons.map(salon => {
        const salonImage = salon.images ? JSON.parse(salon.images)[0].src : null;
        let salonURL = '';
        if(salonImage) {
            salonURL = '/media/salon/' + salonImage;
        } else {
            salonURL = '/media/empty/empty.jpg'
        }
        const linkTo = `/lam-dep/${salon.salon_id}/chi-tiet-salon`;
        return `
<div class="item-salon">
                  <div class="salon-img">
                    <a href="${linkTo}">
                      <img src="${salonURL}" alt="${salon.name}">
                    </a>
                  </div>
                  <div class="salon-content">
<!--                    <div class="location-container">-->
<!--                      <i class="fa-solid fa-map location-salon"></i> &nbsp-->
<!--                      <a href=""><span class="location-text">Xem vị trí trên bản đồ</span></a>-->
<!--                    </div>-->
                    <div class="salon-title">
                        <a href="${linkTo}" style="text-decoration: none;">
                            <div class="salon-title-name">
                                <span>${salon.name}</span>
                          </div>
                        </a>

                      <div class="salon-title-address">
                        <div class="salon-title-address-location">
                          <i class="fa-solid fa-location-dot"></i>
                          <span>${salon.address}, ${salon.location.address}</span>
                        </div>
                        <div>
                               ${
                                    `<i class="fa-solid fa-star" style="color: #ffd43b; font-size: 15px;"></i>`.repeat(salon.star)
                                }
                        </div>
                      </div>
                    </div>
                    <div class="salon-service">

                    </div>
                    <div class="view-detail">
                      <a href="${linkTo}">Xem chi tiết tiết</a>
                    </div>
                  </div>
                </div>
    `
            ;
    }).join('');
    return salonHtml;
}
