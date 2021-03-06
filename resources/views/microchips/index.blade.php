@extends('layouts.master')
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@section('content')
<div id="content">
<div class="wrapper">
<div class="page-header">

</div>

          <div class="content-i">
            <div class="content-box">
              <div class="element-wrapper">
                <h6 class="element-header">
                  Microchips
                </h6>
                <div class="element-box">
                  <h5 class="form-header">
                   Microchips - List 
                    <div style="float: right; position: inherit;">
                      <a href="{{ route('microchips.create') }}" class="btn btn-lg btn-success">
                        <i class="fa fa-plus-circle"> New</i>
                      </a>
                    </div>
                  </h5>
                  @if ($message = Session::get('success'))
                  <p></p>
                    <div class="alert alert-success" id="msg">
                        <p>{{ $message }}</p>
                    </div>
                  @elseif ($message = Session::get('danger'))
                    <div class="alert alert-danger" id="error">
                        <p>{{ $message }}</p>
                    </div>
                  @endif
                    <div class="form-desc">
                      <!-- <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a> -->
                    </div>
                  <div class="table-responsive">
                    <table id="dataTable1" width="100%" class="table table-sm table-bordered table-hover table-lightfont">
                      <thead>
                        <tr>
                          <th class="text-primary" style="width:  4.33%">S.no</th>
                          <th class="text-primary">Microchip</th>
                          <th class="text-primary">LOT</th>
                          <th class="text-primary">Assigned To</th>
                          <th class="text-primary">Valid Date</th>
                          <th class="text-primary">Status</th>
                          <th class="text-primary">Created</th>
                          <th class="text-primary">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $i = 1;
                        ?>
                      @foreach ($microchip as $key => $micro)
                          <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $micro->microchip }}</td>
                            <td>{{ $micro->LOT }}</td>
                            <td>{{ $micro->assigned_to }}</td>
                            <td>{{ date('d-m-Y', strtotime($micro->valid_date)) }}</td>
                            <td>
                              @if($micro->status == 'Used')
                                <span class="badge badge-success">{{ $micro->status }}</span>
                              @elseif($micro->status == 'Instock')
                                <span class="badge badge-warning">{{ $micro->status }}</span>
                              @else
                                <span class="badge badge-secondary">{{ $micro->status }}</span>
                              @endif
                            </td>
                            <td>{{ date('d-m-Y h:i:s', strtotime($micro->created_at)) }}</td>
                            <td class="row-actions">
                              <a href="{{ route('microchips.edit',$micro->id) }}" data-toggle="tooltip" data-placement="top"
                                  title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
                              <a class="danger pointer" onclick="deleteData({{$micro->id}})" type="submit" data-id="{{$micro->id}}" data-toggle="tooltip" data-placement="top"
                                  title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
                            </td>
                          </tr>
                        @endforeach 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    function deleteData(id){
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url : "{{ url('/microchipsStatusUpdate')}}" + '/' + id,
                    type : "GET",
                    data : {'_method' : 'PUT'},
                    success: function(data){
                        swal("Done! Record successfully deleted!", {
                        icon: "success",
                        }).then(function() {
                            window.location = "microchips";
                        });
                    },
                    error : function(){
                        swal({
                            title: 'Opps...',
                            text : data.message,
                            type : 'error',
                            timer : '1500'
                        })
                    }
                })
            } else {
            swal("Your record is safe!");
            }
        });
      }
  </script>

@endsection