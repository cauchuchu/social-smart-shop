{block name='content'} <style>
    </style>
    <div class="be-contents">
      <div class="page-head">
        <h2 class="page-head-title">Tạo mới đơn hàng</h2>
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb page-head-nav">
            <li class="breadcrumb-item">
              <a href="#">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
              <a href="order">Đơn hàng</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="main-content container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header card-header-divider">Nội dung đơn hàng </div>
              <div class="card-body">
                <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="employee/store">
                <div class="row ">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label for="order_name"><b>Mã đơn</b></label>
                      <input type="text" class="form-control" disabled id="order_name" value="DH00{$lastOrder}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                      <label for="to_date"><b>Ngày đặt hàng</b></label>
                    <div class="input-group date datetimepicker pd-0" data-date="2024-09-16T05:25:07Z" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                      <input class="form-control order_date" size="16" data-min-view="2" type="text" value="" placeholder="">
                      <div class="input-group-append">
                        <button class="btn btn-primary">
                          <i class="icon-th mdi mdi-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <hr class="classhr">
              <div class="row ">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label for="order_name"><b>Khách hàng</b><span style="color:red"> (*)</span></label>
                      <select class="form-control">
                        <option>Chọn</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                  <label for="order_name">Ấn nếu là khách hàng mới</label>
                  <button class="btn btn-space btn-primary" type="button">Ấn nếu là khách hàng mới</button>
                  </div>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-6">
                  <div class="form-group">
                  <input type="text" class="form-control" disabled id="customer_name" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                  <input type="text" class="form-control" disabled id="address" >
                  </div>
                </div>
              </div>
                <hr>
                <div class="row ">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label for="order_name"><b>Trạng thái giao hàng</b></label>
                      <select class="form-control">
                        <option>Chọn</option>
                      </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                  <label for="order_name"><b>Trạng thái thanh toán</b></label>
                  <select class="form-control">
                    <option>Chọn</option>
                  </select>
                  </div>
                </div>
              </div>
              <hr>
                <div class="row ">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label for="order_name"><b>Giao đơn hàng cho</b></label>
                      <select class="form-control">
                        <option>Chọn</option>
                      </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                  <label for="order_name"><b>Mô tả đơn hàng</b></label>
                  <textarea class="form-control heigh-48" style="height: 48px;"></textarea>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
              <div class="col-lg-12">
              <label><b>Sản phẩm của đơn hàng</b><span style="color:red"> (*)</span></label>
              <div id="div_product_detail">
              <input type="hidden" name="attribute_config" id="attribute_config" value="">
              <table id="tbl_config_detail" celspacing=0 celpadding=0 class="table_custom">
                <thead>
                  <tr>
                    <th width="10%">Sản phẩm <span style="color:red"> (*)</span></th>
                    <th width="2%">Số lượng <span style="color:red"> (*)</span></th>
                    <th width="5%">Giá bán <span style="color:red"> (*)</span></th>
                    <th width="10%">
                      <span class="btn btn-success btn-sm btn-view" onclick="addRow($(this))">Thêm dòng</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bodySortable" id="tbl_detail">
                  <tr>
                    <td width="15%">
                      <select class="input_detail_pOder" style="width: 99%;">
                        <option>3434</option>
                      </select>
                    </td>
                    <td width="3%">
                      <input style="width: 95%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_qty input_detail_pOder" value="">
                    </td>
                    <td width="5%">
                    <input style="width: 90%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_price input_detail_pOder" value="">
                    </td>
                    <td>
                      <span style="background-color: rgb(239, 191, 128);margin-bottom: 4px;" class="btn btn-sm btn-view" onclick="removeRow($(this))">Xóa dòng</span>
                    </td>
                  </tr>
                </tbody>
                <tfoot hidden>
                  <tr>
                    <td width="15%">
                    <select class="input_detail_pOder" style="width: 99%;">
                    <option>3434</option>
                  </select>
                    </td>
                    <td width="3%">
                      <input style="width: 95%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_qty input_detail_pOder" value="">
                    </td>
                    <td width="5%">
                    <input style="width: 90%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_price input_detail_pOder" value="">
                    </td>
                    <td>
                      <span style="background-color: rgb(239, 191, 128);    margin-bottom: 4px;" class="btn btn-sm btn-view" onclick="removeRow($(this))">Xóa dòng</span>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
              </div>
              </div>

              <div class="row mt-3">
              <div class="col-lg-6">
              <div class="form-group">
                  <label for="order_name">Giảm giá (Nhập nếu có)</label>
                  <input style="width: 100%;" type="text" onkeyup="formatNumber(this)" maxlength="350" class="discount form-control" value="">
              </div>
            </div>
              </div>

              <div class="row">
              <div class="col-lg-6">
              <div class="form-group">
                  <label for="order_name">Tổng tiền đơn hàng:  <b class="final_price_text">1000,000 vnd</b></label>
                  <input type="hidden" maxlength="350" class="final_price form-control" value="">
              </div>
            </div>
              </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div id="addOption" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <lable>Nhập tên đơn vị mới</lable>
          <input class="form-control new_option" type="text" placeholder="Nhập tên đơn vị">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary add_new_option">Lưu</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
        </div>
      </div>
  
    </div>
  </div>
    <script src="..\assets\js\order.js" type="text/javascript"></script> {/block}