@extends('admin/layouts/default')

@section('title')
OperationIncommings
@parent
@stop
@section('content')
  @include('common.errors')
    <section class="content-header">
     <h1>OperationIncommings Edit</h1>
     <ol class="breadcrumb">
         <li>
             <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                 Dashboard
             </a>
         </li>
         <li>OperationIncommings</li>
         <li class="active">Edit OperationIncomming </li>
     </ol>
    </section>
    <section class="content paddingleft_right15">
      <div class="row">
             <div class="col-sm-12">
              <div class="card panel-primary">
                    <div class="card-heading">
                        <h4 class="card-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Edit  OperationIncomming
                        </h4></div>
                    <br />
                <div class="card-body">
                {!! Form::model($operationIncomming, ['route' => ['admin.operationIncommings.update', collect($operationIncomming)->first() ], 'method' => 'patch']) !!}

                @include('admin.operationIncommings.fields')

                {!! Form::close() !!}
                </div>
              </div>
           </div>
    </div>
   </section>
 @stop
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("form").submit(function() {
                $('input[type=submit]').attr('disabled', 'disabled');
                return true;
            });
        });
    </script>
@stop
