@extends('admin.template.master')
@section('content')
<section class="content">
    <div class="row">
      <div class="col-xs-12"><!-- /.col-xs-12 -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h1 class="font-18 m-0">Timedoor Challenge - Level 9</h1>
          </div>
          <form method="" action="">
            <div class="box-body">
              <div class="bordered-box mb-20">
                <form class="form" role="form">
                  <table class="table table-no-border mb-0">
                    <tbody>
                      <tr>
                        <td width="80"><b>Title</b></td>
                        <td><div class="form-group mb-0">
                          <input id="title-search" type="text" class="form-control">
                          </div></td>
                      </tr>
                      <tr>
                        <td><b>Body</b></td>
                        <td><div class="form-group mb-0">
                          <input id="body-search" type="text" class="form-control">
                          </div></td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-search">
                    <tbody>
                      <tr>
                        <td width="80"><b>Image</b></td>
                        <td width="60">
                          <label class="radio-inline">
                            <input type="radio" name="imageOption" id="inlineRadio1" value="with"> with
                          </label>
                        </td>
                        <td width="80">
                          <label class="radio-inline">
                            <input type="radio" name="imageOption" id="inlineRadio2" value="without"> without
                          </label>
                        </td>
                        <td>
                          <label class="radio-inline">
                            <input type="radio" name="imageOption" id="inlineRadio3" value="" checked> unspecified
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td width="80"><b>Status</b></td>
                        <td>
                          <label class="radio-inline">
                            <input type="radio" name="statusOption" id="inlineRadio1" value="on"> on
                          </label>
                        </td>
                        <td>
                          <label class="radio-inline">
                            <input type="radio" name="statusOption" id="inlineRadio2" value="delete"> delete
                          </label>
                        </td>
                        <td>
                          <label class="radio-inline">
                            <input type="radio" name="statusOption" id="inlineRadio3" value="" checked> unspecified
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="#" class="btn btn-default mt-10" onclick="search_data()"><i class="fa fa-search"></i> Search</a></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
              <table id="post-table" class="table table-bordered">
                <thead>
                  <tr>
                    <th><input type="checkbox" onchange="check_all($(this))"></th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th width="200">Image</th>
                    <th>Date</th>
                    <th width="50">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
              <a href="#" class="btn btn-default mt-5" data-toggle="modal" data-target="#modal" onclick="modal(get_checked_val(), 'delete_post')">Delete Checked Items</a>
              <div class="text-center">
                <nav>
                  <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.col-xs-12 -->
    </div>
  </section>
@endsection

@section('js-page')
  <script>
    // BOOTSTRAP TOOLTIPS
    if ($(window).width() > 767) {
      $(function () {
        $('[rel="tooltip"]').tooltip()
      });
    };

    // DATATABLE
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var ajax       = {
      type: 'POST',
      url: '{{ route('admin.table') }}',
      data: {
        _token: csrf_token
      }
    };

    var table = $('#post-table').DataTable(table_option());

    function table_option(){
      return {
        lengthChange: false,
        searching: false,
        autoWidth: false,
        serverSide: true,
        processing: true,
        order: false,
        pageLength: 20,
        dom: "lfrti",
        ajax: ajax,
        columns: [
          {data: 'checkbox', name: 'checkbox', sortable: false},
          {data: 'id', name: 'id', sortable: false},
          {data: 'title', name: 'title', sortable: false},
          {data: 'body', name: 'body', sortable: false},
          {data: 'image_html', name: 'image_html', sortable: false},
          {data: 'date', name: 'date', sortable: false},
          {data: 'action', name: 'action', sortable: false},
        ],
        drawCallback: function(setting) {
          json        = setting.json;
          currentPage = json.input.start / json.input.length;
          prevPage    = currentPage - 1;
          nextPage    = currentPage + 1;

          $('.pagination').empty();
          $('.pagination').append(
            '<li><a href="#" onclick="jump_page(' + prevPage + ')">&laquo;</a></li>'
          );
          for (let i = 0; i < json.recordsTotal / 20; i++) {
            $('.pagination').append(
              '<li class="' + ((currentPage == i) ? "active" : "") + '"><a href="#" onclick="jump_page(' + i + ')">' + (i + 1) + '</a></li>'
            );
          }
          $('.pagination').append(
            '<li><a href="#" onclick="jump_page(' + nextPage + ')">&raquo;</a></li>'
          );
        },
        fnRowCallback: function(nRow, aData) {
          datetime = new Date(aData.created_at);
          arr_date = [datetime.getFullYear(), ("0" + (datetime.getMonth() + 1)).slice(-2), datetime.getDate()];
          arr_time = [(datetime.getHours() - 1), datetime.getMinutes(), datetime.getSeconds()]; 
          date     = arr_date.join('/');
          time     = arr_time.join(':');

          if (aData.deleted_at) {
            $('td', nRow).addClass('bg-gray-light');
            $('td > input[type="checkbox"]', nRow).remove();
            $('td > .btn-restore-post', nRow)
              .removeClass('hide')
              .attr('onclick', 'modal(' + aData.id + ', "restore_post")');
          } else {
            $('td > .btn-delete-post', nRow)
              .removeClass('hide')
              .attr('onclick', 'modal(' + aData.id + ', "delete_post")');
          }

          if (!aData.image) {
            $('td > .img-html', nRow).remove();
          }

          $('td > input[type="checkbox"]', nRow).val(aData.id);
          $('td > .btn-delete-image', nRow).attr('onclick', 'modal(' + aData.id +  ', "delete_image")');
          $('td > .datetime', nRow).prepend(date);
          $('td > .datetime .time', nRow).html(time);
          $('td > img', nRow).attr('src', '{{ asset('storage/post') }}/' + aData.image);
        }
      };
    }

    function jump_page(page){
      table.page(page).draw('page');
    }

    function search_data(){
      ajax = {
        type: 'POST',
        url: '{{ route('admin.table', ['search' => TRUE]) }}',
        data: {
          body: $('#body-search').val(),
          title: $('#title-search').val(),
          image: $('input[name="imageOption"]:checked').val(),
          status: $('input[name="statusOption"]:checked').val(),
          _token: csrf_token
        }
      };

      table.destroy();
      table = $('#post-table').DataTable(table_option());
    }

    function check_all(element){
      $(".checkbox-post").filter(function(){
        if (element.prop("checked")) {
          $(this).prop("checked", true);
        } else {
          $(this).prop("checked", false);
        }
      });
    }

    function get_checked_val(){
      var arr_id = []

      $(".checkbox-post").filter(function(){
        if ($(this).prop("checked")) {
          arr_id.push($(this).val());
        }
      });

      return (arr_id.length > 0) ? arr_id.toString() : arr_id;
    }

    function modal(id, type){
      $.ajax({
        type: 'POST',
        url: '{{ route('admin.modal') }}',
        data: {
          id: id,
          type: type,
          _token: csrf_token
        },
        success: function(response){
          $('.modal-content').empty().html(response);
          $('.form-action').ajaxForm({
            success: function () {
              table.ajax.reload(null, false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              alert(thrownError);
            }
          });
        }
      });
    }

    function modal_dismiss(){
      $('#modal').modal('toggle');
    }
  </script>
@endsection