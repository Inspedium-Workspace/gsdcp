@extends('layouts.master')
<style type="text/css">
.pointer {cursor: pointer;}
</style>
@section('content')
  <div class="content-i">
    <div class="content-box">
      <div class="element-wrapper">
        <h6 class="element-header">
            Role Management
        </h6>
        <div class="element-box">
          <h5 class="form-header">
            Roles - List
            <div style="float: right; position: inherit;">
              <a href="{{ route('roles.create') }}" class="btn btn-lg btn-success">
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
          <div class="alert alert-danger" id="msg">
              <p>{{ $message }}</p>
          </div>
        @endif
          <div class="form-desc">
            <!-- <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a> -->
          </div>
          <div class="table-responsive">
            <table id="dataTable1" width="100%" class="table table-striped table-bordered table-lightfont">
            	<thead>
            		<tr>
            			<th style="width:  4.33%">S.no</th>
            			<th>Role</th>
                        <th>Actions</th>
            		</tr>
            	</thead>
            	<tfoot>
            		<tr>
            			<th style="width:  4.33%">S.no</th>
            			<th>Role</th>
                        <th>Actions</th>
            		</tr>
            	</tfoot>
            	<tbody>
            		<?php
      					 $i = 1;
      					?>
					    @foreach ($roles as $key => $role)
                	<tr>
                    <td>{{ $i++ }}</td>
                   
                    <td>{{ $role->name }}</td>
        
                    <td class="row-actions">
                      <a href="{{ route('roles.edit',$role->id) }}" data-toggle="tooltip" data-placement="top"
                          title="Edit"><i class="os-icon os-icon-ui-49"></i></a>

                          <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                          {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                          {{ Form::button('<i class="os-icon os-icon-ui-15"></i>', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete'] )  }}
                          {!! Form::close() !!}

                    
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
                    url : "{{ url('/destroy')}}" + '/' + id,
                    type : "GET",
                    data : {'_method' : 'DELETE'},
                    success: function(data){
                        swal("Done! Record successfully deleted!", {
                        icon: "success",
                        }).then(function() {
                            window.location = "KCPNumber";
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


