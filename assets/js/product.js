$(document).ready(function () {
    var table = $('#tableProduct').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "product/list",
            "type": "GET",
            "data": function(d) {
                d.start = d.start;
                d.length = d.length;
                d.draw = d.draw;
                // d.from_date = $('#from_date').val();
                // d.to_date = $('#to_date').val();
                // d.in_by = $('#in_by_search').val();
            }
        },
        "columns": [
            {
                "data": null, 
                "render": function(data, type, row) {
                    if(row.image){
                        return '<img class="image_product" src="../public/'+row.image+'">';
                    } else{
                        return '<img class="image_product" src="../assets/img/product.jpg">';
                    }
                    
                }
            },
            {
                "data": null, 
                "render": function(data, type, row) {
                    return '<a href="product-detail?id=' + row.id + '"> '+row.product_name+'</a>';
                }
            },
            {
                "data": null, 
                "render": function(data, type, row) {
                    if(row.status==1){
                        return ' <button class="btn btn-space btn-outline-success btn-space" id="swal-col-success">Đang bán</button>';
                    } else{
                        return '<button class="btn btn-space btn-outline-danger btn-space" id="swal-col-danger">Ngừng bán</button>';
                    }
                    
                }
            },
            {
                "data": "price", 
                "render": function(data, type, row) {
                    return data + " đ"; 
                }
            },
            { "data": "sold" },
            {
                "data": null, 
                "render": function(data, type, row) {
                    return '<div class="d-flex"><div><a href="product-edit?id=' + row.id + '" class="btn btn-space btn-primary" type="button"> Sửa</a></div>' +
    (row.status == 1 ? ' <div><button class="btn btn-space btn-danger btnDelProduct" attr-id="' + row.id + '"><i class="icon icon-left mdi mdi-alert-circle"></i>Xóa</button></div>' : '') +
    '</div>';

                }
            }
        ],
        "pageLength": 20 ,
        "language": {
            "search": "Tìm kiếm nhanh"
        },
        "lengthChange": false,
         "dom": '<"top"f>rt<"bottom"ilp><"clear">'
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });

    $('.saveproduct').on('click', function (e) {
        var name = $('#product_name').val();      
        var description = $('#description').val();      
        var status = $('#status').val();      
        var unit = $('.detail_product_unit').val();      
        var price = $('.price').val();   
        var avatar = $("#avatar")[0].files[0];   

        if (name === '') {
            notify('Vui lòng nhập tên sản phẩm', 'error');
            return;
        } 
        if (name.length >= 100) {
            notify('Tên quá dài, vui lòng đặt lại', 'error');
            return;
        } 
        if (price === '') {
            notify('Vui lòng nhập giá bán', 'error');
            return;
        }
        if (unit === '') {
            notify('Vui lòng chọn đơn vị', 'error');
            return;
        }
       
        var formData = new FormData();
            formData.append('name', name);
            formData.append('status', status);
            formData.append('price', price);
            formData.append('unit', unit);
            formData.append('description', description);
        if (avatar) {
            formData.append('image', avatar);  // Thêm file avatar vào FormData
        }
        $.ajax({
            url: 'product/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Tạo thành công!','success');
                    // Thực hiện redirect hoặc hành động khác
                    window.location.href = 'product';
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

    $('.saveEditproduct').on('click', function (e) {
        var id = $('#id').val();      
        var name = $('#product_name').val();      
        var description = $('#description').val();      
        var status = $('#status').val();      
        var unit = $('.detail_product_unit').val();      
        var price = $('.price').val();   
        var avatar = $("#avatar")[0].files[0];   

        if (name === '') {
            notify('Vui lòng nhập tên sản phẩm', 'error');
            return;
        } 
        if (name.length >= 100) {
            notify('Tên quá dài, vui lòng đặt lại', 'error');
            return;
        } 
        if (price === '') {
            notify('Vui lòng nhập giá bán', 'error');
            return;
        }
        if (unit === '') {
            notify('Vui lòng chọn đơn vị', 'error');
            return;
        }
       
        var formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('status', status);
            formData.append('price', price);
            formData.append('unit', unit);
            formData.append('description', description);
        if (avatar) {
            formData.append('image', avatar);  // Thêm file avatar vào FormData
        }
        $.ajax({
            url: 'product/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Chỉnh sửa thành công!','success');
                    // Thực hiện redirect hoặc hành động khác
                    window.location.href = 'product';
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

    $(document).on("click",".btnDelProduct",function() {
        if (confirm("Sản phẩm sẽ chuyển trạng thái về ngừng bán!")) {
            var id = $(this).attr('attr-id'); 
            $.ajax({
                url: 'product/update',
                type: 'POST',
                data: {
                    id : id,
                    status : '0'
                },
                success: function (response) {
                    if (response.success) {
                        notify('Chỉnh sửa thành công!','success');
                        window.location.href = 'product';
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
        }
    });
});