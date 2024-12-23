
$(document).ready(function () {
    // dangky
    // Xử lý sự kiện submit form
    $('#signup-form').on('submit', function (e) {
        e.preventDefault(); 

        var mobile = $('.mobile').val();
        var password = $('.password').val();
        var shop_name = $('.shop_name').val();
        var name = $('.name').val();      
        if (mobile === '') {
            notify('Số điện thoại không được để trống', 'error');
            return;
        }
        if (!/^\d{10}$/.test(mobile)) { // Kiểm tra định dạng số điện thoại
            notify('Số điện thoại không hợp lệ', 'error');
            return;
        }
        if (password === '') {
            notify('Mật khẩu không được để trống', 'error');
            return;
        }
        if (shop_name === '') {
            notify('Tên cửa hàng không được để trống', 'error');
            return;
        }
        if (name === '') {
            notify('Tên không được để trống', 'error');
            return;
        }     

        // Gửi request Ajax
        $.ajax({
            url: 'register',
            type: 'POST',
            data: {
                mobile: mobile,
                password: password,
                shop_name: shop_name,
                name: name,
            },
            success: function (response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Đăng ký thành công!','success');
                    // Thực hiện redirect hoặc hành động khác
                    window.location.href = 'dashboard';
                } else {
                    notify(response.message,'error');
                    return;
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi
                notify('Có lỗi trong quá trình xử lý, vui lòng thử lại sau!','error');
                console.error(error);
                return;
            }
        });
    }); 
    $('#show-password').click(function() {
        var passwordField = $('.password');
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            $(this).text('Ẩn mật khẩu');  // Thay đổi text của button
        } else {
            passwordField.attr('type', 'password');
            $(this).text('Hiện mật khẩu');  // Thay đổi text của button
        }
    });


    // dangnhap
    $('.login-btn').on('click', function (e) {
        console.log(123);
        e.preventDefault(); // Ngăn chặn submit form thông thường

        var mobile = $('#mobile').val();
        var password = $('#password').val();

        if (mobile === '') {
            notify('Số điện thoại không được để trống', 'error');
            return;
        }
        if (password === '') {
            notify('Mật khẩu không được để trống', 'error');
            return;
        }

        // Gửi request Ajax
        $.ajax({
            url: 'check-login', // URL backend để xử lý login
            type: 'POST',
            data: {
                mobile: mobile,
                password: password
            },
            success: function (response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Đăng nhập thành công!','success');
                    // Thực hiện redirect hoặc hành động khác
                    window.location.href = 'dashboard';
                } else {
                    notify(response.message,'error');
                    return;
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi
                notify('Có lỗi trong quá trình xử lý, vui lòng thử lại sau!','error');
                console.error(error);
                return;
            }
        });
    });

    
}); 
