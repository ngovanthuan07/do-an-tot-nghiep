export function loginForm() {
    Swal.fire({
        title: "<span>Đăng nhập với:</span>",
        html: `
            <div class="container">
                <div class="card">
                  <button id="google-login" class="btn btn-lg btn-google btn-block text-uppercase btn-outline">
                      <img src="https://img.icons8.com/color/16/000000/google-logo.png">
                        Đăng nhập với GOOGLE
                  </button>
                </div>
            </div>
          `,
        showCloseButton: true,
        focusConfirm: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Đóng lại!',
        confirmButtonColor: 'rgb(255 204 51)',
    });
}

export function handleLoginForm(newURL) {
    $(document).on('click', '#google-login', function () {
        $.ajax({
            url: newURL,
            type: 'GET',
            success: function(url) {
                // Hiển thị cửa sổ đăng nhập Google
                const width = 500;
                const height = 600;
                const left = (window.innerWidth / 2) - (width / 2);
                const top = (window.innerHeight / 2) - (height / 2);

                let newWindow = window.open(url, '_blank', 'fullscreen=yes,location=no');;

                // Chờ đợi cho đến khi người dùng đăng nhập xong và đóng cửa sổ đó
                var timer = setInterval(function() {
                    if (newWindow.closed) {
                        clearInterval(timer);
                        $.ajax({
                            url: '/me',
                            type: 'GET',
                            success: function(resp) {
                                let data = resp
                                if(data) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Thành công",
                                        text: "Đăng nhập thành công!",
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: "Error",
                                    title: "Lỗi đăng nhập",
                                    text: "Đã bị lỗi vui lòng đăng nhập lại!",
                                    confirmButtonColor: "#d63031",
                                    confirmButtonText: "Đóng",
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // window.location.reload();
                                    }
                                });
                            }
                        });
                    }
                }, 500);
            },
            error: function() {
                alert('Đăng nhập bằng Google thất bại oke.');
            }
        });
    });
}