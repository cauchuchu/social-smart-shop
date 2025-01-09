{block name='content'}
  <style>
    
  </style>
  <div class="be-contents">
    <div class="page-head">
      <h2 class="page-head-title">Chỉnh sửa phiếu nhập hàng</h2>
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
            <div class="card-header card-header-divider">Phiếu nhập {$bill.id_bill}
            </div>
            <div class="card-body">
              <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="">

                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="id_bill">Mã phiếu</label>
                  <div class="col-9 col-lg-4">
                    <input class="form-control" name="id_bill" id="id_bill" value="{$bill.id_bill}" type="text" disabled placeholder="">
                    <input type="hidden" id="id" value="{$bill.id}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="mobile">Ngày nhập</label>
                  <div class="col-9 col-lg-4">
                    <div class="input-group date datetimepicker" data-date="2024-09-16T05:25:07Z"
                      data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1">
                      <input class="form-control date_in" size="16" type="text" value="{$bill.date_in}" >
                      <div class="input-group-append">
                        <button class="btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></button>
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
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bodySortable" id="tbl_detail">
                        {if $productList}
                          {foreach from=$productList item=items}
                            <tr>
                            <td width="10%">
                              <input style="width: 100%;" type="text" maxlength="350" class="detail_product_name input_detail"
                                value="{$items.name}">
                            </td>
                            <td width="2%">
                              <input style="width: 100%;" onkeyup="formatNumber(this)" type="text" maxlength="350"
                                class="detail_product_qty input_detail" value="{$items.qty}">
                            </td>
                            <td width="5%">
                              <select style="width: 80%;" class="detail_product_unit input_detail">
                                <option value="1" {if $items.unit == 1}selected{/if}>Kg</option>
                                <option value="2" {if $items.unit == 2}selected{/if}>Chiếc</option>
                                {if $listUnit}
                                  {foreach from=$listUnit item=item}
                                    <option value="{$item.id}" {if $items.unit == $item.value}selected{/if}>{$item.title}</option>
                                  {/foreach}
                                {/if}
                              </select>
                            </td>
                            <td>
                            </td>
                          </tr>
                          {/foreach}
                          {else}
                            <tr>
                            <td width="10%">
                              <input style="width: 100%;" type="text" maxlength="350" class="detail_product_name input_detail"
                                value="">
                            </td>
                            <td width="2%">
                              <input style="width: 100%;" onkeyup="formatNumber(this)" type="text" maxlength="350"
                                class="detail_product_qty input_detail" value="">
                            </td>
                            <td width="5%">
                              <select style="width: 80%;" class="detail_product_unit input_detail">
                                <option value="1" selected>Kg</option>
                                <option value="2">Chiếc</option>
                                {if $listUnit}
                                  {foreach from=$listUnit item=item}
                                    <option value="{$item.value}">{$item.title}</option>
                                  {/foreach}
                                {/if}
                              </select>
                            </td>
                            <td>
                            </td>
                          </tr>
                        {/if}

                        
                        </tbody>
                        <tfoot hidden>
                          <tr>
                            <td width="10%">
                              <input style="width: 100%;" type="text" maxlength="350" class="detail_product_name input_detail"
                                value="">
                            </td>
                            <td width="2%">
                              <input style="width: 100%;" onkeyup="formatNumber(this)" type="text" maxlength="350"
                                class="detail_product_qty input_detail" value="">
                            </td>
                            <td width="5%">
                              <select style="width: 80%;" class="detail_product_unit input_detail">
                                <option value="1" selected>Kg</option>
                                <option value="2">Chiếc</option>
                                {if $listUnit}
                                  {foreach from=$listUnit item=item}
                                    <option value="{$item.value}">{$item.title}</option>
                                  {/foreach}
                                {/if}
                              </select>
                            </td>
                            <td>
                              
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
                    <input style="width: 100%;" type="text" onkeyup="formatNumber(this)" maxlength="350"
                      class="total_in_pay form-control" value="{$bill.total|number_format:0:",":","}">
                  </div>
                </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Người nhập</label>
                    <div class="col-9 col-lg-4">
                      <select class="form-control" name="in_by" id="in_by">
                        {if $employeeList}
                          {foreach from=$employeeList item=item}
                          <option value="{$item->id}"{if $bill.in_by == $item->id}selected{/if}>{$item->full_name}</option>
                          {/foreach}
                        {/if}
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Mô tả</label>
                    <div class="col-9 col-lg-10">
                      <textarea class="form-control" name="description" id="description">{$bill.description}</textarea>
                    </div>
                  </div>
                  <div class="row pt-2 pt-sm-5 mt-1">
                    <div class="col-sm-6 pl-0">
                      <p class="text-right">
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


  <script src="..\assets\js\income.js" type="text/javascript"></script>
{/block}