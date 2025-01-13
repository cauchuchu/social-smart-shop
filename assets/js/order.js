function addRow(_this) {
    let row = _this.closest("#tbl_config_detail").find("tfoot tr").clone();
    _this.closest("#tbl_config_detail").find("tbody").append(row);
    return row;
}

function removeRow(_this) {
    _this.closest("tr").remove();
}

$(document).ready(function () {
    // Định nghĩa datetimepicker
    $(".order_date").datetimepicker({
        autoclose:!0,componentIcon:".mdi.mdi-calendar",
        format:"dd/mm/yyyy",
        navIcons:{rightIcon:"mdi mdi-chevron-right",leftIcon:"mdi mdi-chevron-left"}
        
    }).datetimepicker('setDate', new Date()); ;

    $('#in_by').select2();
 
    // Định nghĩa DataTable
    var table = $('#tableOrder').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "order/list",
            "type": "GET",
            "data": function(d) {
                d.start = d.start;
                d.length = d.length;
                d.draw = d.draw;
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
                d.in_by = $('#in_by_search').val();
            }
        },
        "columns": [
            { "data": "order_name"},
            {
                "data": "customer_id", 
                "render": function(data, type, row) {
                    return '<a href="customer-detail?id=' + row.customer_id + '"> '+row.customer_name+'</a><div title="'+row.address+'" class="addressCustomer"><i class="icon mdi mdi-home"></i>'+row.address+'</div>';
                }
            },
            {
                "data": "status_delivery", 
                "render": function(data, type, row) {
                    if(row.status_delivery==0){
                        return ' <button class="btn btn-space btn-outline-success btn-space" id="swal-col-success">'+row.status_delivery_value+'</button>';
                    } 
                    else if(row.status_delivery==1){
                        return '<button class="btn btn-rounded btn-space btn-primary w-85" id="">'+row.status_delivery_value+'</button>';
                    }
                    else if(row.status_delivery==2){
                        return '<button class="btn btn-rounded btn-space btn-success w-85" id="">'+row.status_delivery_value+'</button>';
                    }
                    else if(row.status_delivery==3){
                        return '<button class="btn btn-rounded btn-space btn-warning w-85" id="">'+row.status_delivery_value+'</button>';
                    }
                    else if(row.status_delivery==4){
                        return '<button class="btn btn-rounded btn-space btn-danger w-85" id="">'+row.status_delivery_value+'</button>';
                    }
                    
                }
            },
            {
                "data": "status_payment", 
                "render": function(data, type, row) {
                    if(row.status_payment==0){
                        return ' <button class="btn btn-space btn-outline-danger btn-space w-85" id="swal-col-success">'+row.status_payment_value+'</button>';
                    } 
                    else if(row.status_payment==1){
                        return '<button class="btn btn-space btn-outline-secondary btn-space w-85" id="">'+row.status_payment_value+'</button>';
                    }
                    else if(row.status_payment==2){
                        return '<button class="btn btn-space btn-outline-warning btn-space w-85" id="">'+row.status_payment_value+'</button>';
                    }
                    else if(row.status_payment==3){
                        return '<button class="btn btn-space btn-outline-success btn-space w-85" id="">'+row.status_payment_value+'</button>';
                    }
                    
                }
            },
            {
                "data": "final_price", 
                "render": function(data, type, row) {
                    return data + " đ"; 
                }
            },
           
            {
                "data": "product", 
                "render": function(data, type, row) {
                    return '<button class="btn btn-space btn-primary btn-sm" attr-id="">Ấn để xem</button>';
                }
            },
            { "data": "employee_name" },
            {
                "data": "date_order", 
            },
            {
                "data": null, 
                "render": function(data, type, row) {
                    return '<div class="d-flex"><div><a href="order-edit?id=' + row.id + '" class="btn btn-space btn-primary" type="button"> Sửa</a></div>' +
                           ' <div><button class="btn btn-space btn-danger btnDelOrder" attr-id="' + row.id + '">Xóa</button></div></div>';
                }
            }
        ],
        "pageLength": 20 ,
        "searching": false,
        "lengthChange": false,
         "dom": '<"top"f>rt<"bottom"ilp><"clear">'
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });
    var currentSelect = '';


    $(document).on("change",".detail_product_unit",function() {
        if($(this).val() == 'add'){
            $('#addOption').modal({
                // backdrop: 'static',
                // keyboard: true, 
                show: true
        }); 
            currentSelect = $(this);
        }
    });

    $('#addOption').on('hidden.bs.modal', function () {
        currentSelect.val('1').trigger('change');
      });
    
    // Save Income
    $(".saveIncome").on("click", function (e) {
        var arr = [];
        var name_pr = "";
        var qty_pr = "";
        var unit_pr = "";
        $("#tbl_detail tr").each(function (index) {
            name_pr = $(this).find(".detail_product_name").val();
            qty_pr = $(this).find(".detail_product_qty").val();
            unit_pr = $(this).find(".detail_product_unit").val();
            var item = {
                name: name_pr,  
                qty: qty_pr,
                unit: unit_pr
            };
            if(name_pr){
                arr.push(item);
            }
        });

        var attr_cfg = {
            list_detail: arr,
        };
        var id_bill = $("#id_bill").val();
        var date_in = $(".date_in").val();
        var attribute_config = JSON.stringify(attr_cfg);
        var total_in_pay = $(".total_in_pay").val();
        var in_by = $("#in_by").val();
        var description = $("#description").val();

        if (date_in === '') {
            notify('Vui lòng chọn ngày nhập hàng', 'error');
            return;
        } 
        if (total_in_pay === '') {
            notify('Vui lòng nhập tiền hàng', 'error');
            return;
        } 
        $.ajax({
            url: "income/store",
            type: "POST",
            data: {
                id_bill: id_bill,
                date_in: date_in,
                detail_product: attribute_config,
                total_in: total_in_pay,
                in_by: in_by,
                description: description,
            },
            success: function (response) {
                if (response.success) {
                    notify("Tạo phiếu thành công!", "success");
                    window.location.href = "income";
                } else {
                    notify(response.message, "error");
                    return;
                }
            },
            error: function (xhr, status, error) {
                notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                console.error(error);
                return;
            },
        });
    });

    // Save Edit Income
    $(".editIncome").on("click", function (e) {
        var arr = [];
        var name_pr = "";
        var qty_pr = "";
        var unit_pr = "";
        $("#tbl_detail tr").each(function (index) {
            name_pr = $(this).find(".detail_product_name").val();
            qty_pr = $(this).find(".detail_product_qty").val();
            unit_pr = $(this).find(".detail_product_unit").val();
            var item = {
                name: name_pr, 
                qty: qty_pr,
                unit: unit_pr
            };
            if(name_pr){
                arr.push(item);
            }
           
        });

        var attr_cfg = {
            list_detail: arr,
        };

        var id_bill = $("#id_bill").val();
        var date_in = $(".date_in").val();
        var attribute_config = JSON.stringify(attr_cfg);
        var total_in = $(".total_in_pay").val();
        var in_by = $("#in_by").val();
        var description = $("#description").val();
        var id = $("#id").val();

        if (date_in === '') {
            notify('Vui lòng chọn ngày nhập hàng', 'error');
            return;
        } 
        if (total_in === '') {
            notify('Vui lòng nhập tiền hàng', 'error');
            return;
        } 

        $.ajax({
            url: "income/update",
            type: "POST",
            data: {
                id_bill: id_bill,
                date_in: date_in,
                detail: attribute_config,
                total_in: total_in,
                in_by: in_by,
                description: description,
                id: id,
            },
            success: function (response) {
                if (response.success) {
                    notify("Cập nhật phiếu thành công!", "success");
                    window.location.href = "income";
                } else {
                    notify(response.message, "error");
                    return;
                }
            },
            error: function (xhr, status, error) {
                notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                console.error(error);
                return;
            },
        });
    });

    // Delete Income
        $(document).on("click",".btnDelIn",function() {
        if (confirm("Xác nhận xóa phiếu nhập này?")) {
            var id = $(this).attr("attr-id");
            $.ajax({
                url: "income/delete",
                type: "POST",
                data: {
                    id: id,
                },
                success: function (response) {
                    if (response.success) {
                        notify("Xóa thành công!", "success");
                        window.location.href = "income";
                    } else {
                        notify(response.message, "error");
                        return;
                    }
                },
                error: function (xhr, status, error) {
                    notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                    console.error(error);
                    return;
                },
            });
        }
    });

});
