{block name='content'} <style>
   
  </style>
  <div class="be-contents">
    <div class="page-head">
      <h2 class="page-head-title">Thêm mới phiếu nhập hàng</h2>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb page-head-nav">
          <li class="breadcrumb-item">
            <a href="#">Trang chủ</a>
          </li>
          <li class="breadcrumb-item">
            <a href="income">Nhập hàng</a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="main-content container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Phiếu nhập </div>
            <div class="card-body">
              <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="employee/store">
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="id_bill">Mã phiếu</label>
                  <div class="col-9 col-lg-4">
                    <input class="form-control" name="id_bill" id="id_bill" value="INCBILL{$ranId}" type="text" disabled placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="mobile">Ngày nhập</label>
                  <div class="col-9 col-lg-4">
                    <div class="input-group date datetimepicker" data-date="2024-09-16T05:25:07Z" data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1">
                      <input class="form-control date_in" size="16" type="text" value="">
                      <div class="input-group-append">
                        <button class="btn btn-primary">
                          <i class="icon-th mdi mdi-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="password">Hàng hóa</label>
                  <div class="col-9 col-lg-10">
                    <div id="div_goods">
                      <input type="hidden" name="attribute_config" id="attribute_config" value="">
                      <table id="tbl_config_detail" celspacing=0 celpadding=0 class="table_custom">
                        <thead>
                          <tr>
                            <th width="10%">Tên hàng</th>
                            <th width="2%">Số lượng</th>
                            <th width="5%">Đơn vị</th>
                            <th width="10%">
                              <span class="btn btn-success btn-sm btn-view" onclick="addRow($(this))">Thêm dòng</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bodySortable" id="tbl_detail">
                          <tr>
                            <td width="10%">
                              <input style="width: 100%;" type="text" maxlength="350" class="detail_product_name input_detail" value="">
                            </td>
                            <td width="2%">
                              <input style="width: 100%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_qty input_detail" value="">
                            </td>
                            <td width="5%">
                              <select style="width: 80%;" class="detail_product_unit input_detail">
                              <option value="add" class="optionAdd">Thêm đơn vị mới</option>
                                <option value="1" selected>Kg</option>
                                <option value="2">Chiếc</option> {if $listUnit} {foreach from=$listUnit item=item} <option value="{$item.id}">{$item.title}</option> {/foreach} {/if}
                              </select>
                            </td>
                            <td>
                              <span style="background-color: rgb(239, 191, 128);margin-bottom: 4px;" class="btn btn-sm btn-view" onclick="removeRow($(this))">Xóa dòng</span>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot hidden>
                          <tr>
                            <td width="10%">
                              <input style="width: 100%;" type="text" maxlength="350" class="detail_product_name input_detail" value="">
                            </td>
                            <td width="2%">
                              <input style="width: 100%;" onkeyup="formatNumber(this)" type="text" maxlength="350" class="detail_product_qty input_detail" value="">
                            </td>
                            <td width="5%">
                              <select style="width: 80%;" class="detail_product_unit input_detail">
                              <option value="add" class="optionAdd">Thêm đơn vị mới</option>
                                <option value="1" selected>Kg</option>
                                <option value="2">Chiếc</option> {if $listUnit} {foreach from=$listUnit item=item} <option value="{$item.value}">{$item.title}</option> {/foreach} {/if}
                              </select>
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
                <hr>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="role">Tổng tiền nhập</label>
                  <div class="col-9 col-lg-4">
                    <input style="width: 100%;" type="text" onkeyup="formatNumber(this)" maxlength="350" class="total_in_pay form-control" value="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Người nhập</label>
                  <div class="col-9 col-lg-4">
                    <select class="form-control" name="in_by" id="in_by"> {if $employeeList} {foreach from=$employeeList item=item} <option value="{$item->id}">{$item->full_name}</option> {/foreach} {/if} </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Mô tả</label>
                  <div class="col-9 col-lg-10">
                    <textarea class="form-control" name="description" id="description"></textarea>
                  </div>
                </div>
                <div class="row pt-2 pt-sm-5 mt-1">
                  <div class="col-sm-6 pl-0">
                    <p class="text-right">
                      <button class="btn btn-space btn-primary saveIncome" type="button">Lưu</button>
                      <a href="income" class="btn btn-space btn-secondary">Quay lại danh sách</a>
                    </p>
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
  <script src="..\assets\js\income.js" type="text/javascript"></script> {/block}