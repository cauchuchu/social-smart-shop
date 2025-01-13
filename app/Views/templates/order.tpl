{block name='content'}
    <style>
        
    </style>
    <div class="be-contents">
        <div class="page-head">
            <h2 class="page-head-title">Danh sách đơn hàng</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item">
                        <a href="#">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Đơn hàng</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="main-contents container-fluid">
        <div class="row">
            <div class="col-lg-12">
              <div class="card card-border-color card-border-color-primary">
                <div class="card-body">
                 
                    <div class="row pt-3">
                      <div class="col-lg-4">
                        <div class="form-group">
                            <label for="from_date">Từ ngày</label>
                            <input type="text" class="form-control date-picker" data-min-view="2" id="from_date" placeholder="Tìm kiếm phiếu tạo từ ngày..">
                        </div>
                        
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                            <label for="to_date">Đến ngày</label>
                            <input type="text" class="form-control date-picker" data-min-view="2" id="to_date" placeholder="Tìm kiếm phiếu tạo đến ngày..">
                        </div>
                      </div>
                      <div class="col-lg-4">
                      <div class="form-group">
                      <label for="in_by_search">Tìm kiếm theo người nhập hàng</label>
                      <select type="text" class="form-control" id="in_by_search" placeholder="Tìm kiếm theo người tạo">
                          <option value="">Chọn người nhập hàng</option>
                          {if $employeeList}
                              {foreach from=$employeeList item=item}
                                <option value="{$item->id}">{$item->full_name}</option>
                              {/foreach}
                            {/if}
                      </select>
                  </div>
                      </div>
                    </div>
                    <div class="row pt-3">
                    <div class="col-lg-6 pb-4 pb-lg-0 text-right">
                      <button type="button" id="searchBtn" class="btn btn-space btn-primary"><i class="mdi mdi-search"> </i> Tìm kiếm</button>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            
          </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="cards card-tables">
                        <div class="addnew"> <a href="order-add" class="btn btn-space btn-primary" type="button">Tạo đơn hàng</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="noSwipe">

                            <table class="table table-striped table-hover be-table-responsive" id="tableOrder">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">
                                            Mã đơn hàng
                                        </th>
                                        <th>Khách hàng</th>
                                        <th>TT Giao hàng</th>
                                        <th>TT Thanh toán</th>
                                        <th>Tổng tiền</th>
                                        <th>Sản phẩm</th>
                                        <th>Giao cho</th>
                                        <th>Ngày đặt</th>
                                        <th style="width:10%;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="..\assets\js\order.js" type="text/javascript"></script>
{/block}