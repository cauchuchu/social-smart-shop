{block name='content'}
  <style>
   
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
            <div class="addnew"> <a href="employee-add" class="btn btn-space btn-primary" type="button">Thêm nhân viên</a>
            </div>
          </div>
          <div class="card-body">
            <div class="noSwipe">

              <table class="table table-striped table-hover be-table-responsive" id="table1">
                <thead>
                  <tr>
                    <th style="width:10%;">
                      Avatar
                    </th>
                    <th style="width:15%;">Họ tên</th>
                    <th style="width:15%;">Số điện thoại</th>
                    <th style="width:15%;">Quyền</th>
                    <th style="width:15%;">Trạng thái</th>
                    <th style="width:10%;">Công/đơn</th>
                    <th style="width:15%;">Lần đăng nhập cuối</th>
                    <th style="width:10%;">Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$list_employee item=item}
                    <tr class="success done">
                      <td class="">
                  <img src="{if $item->avatar}../public/{$item->avatar}{else}..\assets\img\avatar.png{/if}" class="user-avatars" >
                      </td>
                      <td class=" cell-detail user-info">
                        <a href="employee-detail?id={$item->id}">{$item->full_name}</a>
                      </td>
                      <td class="cell-detail" data-project="Bootstrap">
                        {$item->mobile}
                      </td>
                      <td class="milestone" data-progress="0,45">

                        <div class="btn-group btn-space">
                          {if  {$item->role_id == 1}}
                            <button class="btn btn-color btn-social btn-twitter" type="button"><i
                                class="icon mdi mdi-face"></i></button>
                            <button class="btn btn-secondary" type="button">{$item->title}</button>
                          </div>
                        {else}
                          <button class="btn btn-color btn-social btn-google-plus" type="button"><i
                              class="icon mdi mdi-github-alt"></i></button>
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
                      <td class="text-right d-flex">
                        {if $roleadmin == 1}
                          <div>
                            <a href="employee-edit?id={$item->id}" class="btn btn-space btn-primary" type="button"> Sửa</a>
                          </div>
                          <div>
                          <button class="btn btn-space btn-danger btnDelEpl" attr-id="{$item->id}"><i class="icon icon-left mdi mdi-alert-circle"></i>Xóa</button>
                          </div>
                        {/if}
                      </td>
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