
{block name='content'}
<style>
    .card-body {
        background: #fff;
    }
    .btn-twitter {
        background-color: #2fc664 !important;
    }
    #table1_filter {
        margin-bottom: 15px;
    }
    #table1_filter input {
        width: auto;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .card-tables {
        text-align: right;
        margin-bottom: 10px;
    }
</style>
 <div class="be-contents">
  <div class="page-head">
    <h2 class="page-head-title">Quản lý nhân viên</h2>
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb page-head-nav">
        <li class="breadcrumb-item">
          <a href="#">Trang chủ</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#">Nhân viên</a>
        </li>
      </ol>
    </nav>
  </div>
  <div class="main-contents container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="cards card-tables">
            <div class="addnew"> <a href="employee-add" class="btn btn-space btn-primary" type="button">Thêm nhân viên</a></div>
        </div>
        <div class="card-body">
          <div class="noSwipe">
          
            <table class="table table-striped table-hover be-table-responsive" id="table1">
              <thead>
                <tr>
                  <th style="width:5%;">
                    STT
                  </th>
                  <th style="width:15%;">Họ tên</th>
                  <th style="width:15%;">Số điện thoại</th>
                  <th style="width:15%;">Quyền</th>
                  <th style="width:15%;">Trạng thái</th>
                  <th style="width:10%;">Công/đơn</th>
                  <th style="width:15%;">Lần đăng nhập cuối</th>
                  <th style="width:10%;"></th>
                </tr>
              </thead>
              <tbody>
              {assign var="counter" value=1}
              {foreach from=$list_employee item=item}
                <tr class="success done">
                  <td>
                   {$counter}
                  </td>
                  <td class="user-avatar cell-detail user-info">
                    {$item->full_name}
                  </td>
                  <td class="cell-detail" data-project="Bootstrap">
                     {$item->mobile}
                  </td>
                  <td class="milestone" data-progress="0,45">
                   
                   <div class="btn-group btn-space">
                    {if  {$item->role_id == 1}}
                      <button class="btn btn-color btn-social btn-twitter" type="button"><i class="icon mdi mdi-face"></i></button>
                      <button class="btn btn-secondary" type="button">{$item->title}</button>
                    </div>
                    {else}
                        <button class="btn btn-color btn-social btn-google-plus" type="button"><i class="icon mdi mdi-github-alt"></i></button>
                        <button class="btn btn-secondary" type="button">{$item->title}</button>
                    {/if}
                  </td>
                   <td class="milestone" data-progress="0,45">
                   {if  {$item->status == 1}}
                    <button class="btn btn-space btn-outline-success btn-space" id="swal-col-success">Hoạt động</button>
                    {else}
                    <button class="btn btn-space btn-outline-danger btn-space" id="swal-col-danger">Tạm dừng</button>
                    {/if}
                  </td>
                  <td class="cell-detail">
                    {$item->price_pay|number_format:0:',':'.'} đ
                  </td>
                  <td class="cell-detail">
                    <span>{$item->login_time|date_format:"%d/%m/%Y %H:%M"}
                    </span>
                  </td>
                  <td class="text-right">
                  {if $roleadmin == 1}
                      <div class="btn-group btn-space">
                        <a href=" employee/{$item->id}" class="btn btn-secondary" type="button"><i class="icon mdi mdi-edit"></i> Sửa</a>
                      </div>
                  {/if}
                  </td>
                  {assign var="counter" value=$counter+1}
                {/foreach}
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> 
{/block}
