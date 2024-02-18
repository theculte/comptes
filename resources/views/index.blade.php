@extends('layouts/default')

{{-- Page title --}}
@section('title')
Home
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css starts-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/tabbular.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/index.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/animate/animate.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/jquery.circliful.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.carousel.css') }}">
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.theme.css') }}">
<link href="{{ asset('vendors/selectize/css/selectize.css') }}" rel="stylesheet"/>
<link href="{{ asset('vendors/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet"/>
<link href="{{ asset('vendors/dropzone/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
<style>
	.dropzone .dz-preview .dz-image img {
		width :100%;
	}
</style>
<style>
    .box{
        margin-top:53px !important;
    }
    .level1 span i { font-size:1.5em; }
    .level1 i.fa-plus-square { color:blue;position:relative;top:-13px; }
    .level1 i.fa-minus-square { color:blue;position:relative;top:-13px; }
    #catForm ul li { margin-bottom:10px; }
    #catForm ul { padding-left:0; }
    #catForm ul li ul { padding-left:10px;margin-top:7px; }
    #addCatDiv { border-bottom: 1px solid grey; }
    @foreach($categories as $category)
	.abc-radio-{!! $category->id !!} input[type=radio] + label::after { background-color: {!! $category->color !!}; }
	.abc-radio-{!! $category->id !!} input[type=radio]:checked + label::before { border-color: {!! $category->color !!}; }
	.abc-radio-{!! $category->id !!} input[type=radio]:checked + label::after { background-color: {!! $category->color !!}; }
	.abc-radio-{!! $category->id !!} label { padding:0; }
	.abc-radio-{!! $category->id !!} span { display:inline-block;width:20px;color:{!! $category->color !!};position:relative;top:-13px;left:-5px; }

    @endforeach

</style>
<link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/scroller.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/awesome-bootstrap-checkbox.css') }}"/>

<!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
@stop

{{-- content --}}
@section('content')

<section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-lg-9">
            <div class="col-lg-12">
	    	<div class="card " style="overflow-y:auto; overflow-x: hidden">
                    <div class="card-header bg-info text-white">
                        <span>
                            <i class="livicon" data-name="upload-alt" data-size="20" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Solde à venir le {{$dateEndMonth}}
                        </span>
                    </div>
                    <div class="card-body" style="padding:0px !important;">
                        <div class="col-md-12" style="text-align:center;font-size:35px;color:green;padding:30px;">
				{{$soldeEndMonth}}
			</div>
                    </div>
                </div>
	    </div>
	    </div>
            <div class="col-lg-3">
                <!-- First Basic Table strats here-->
                <div class="card " style="overflow-y:auto; overflow-x: hidden">
                    <div class="card-header bg-info text-white">
                        <span>
                            <i class="livicon" data-name="upload-alt" data-size="20" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Fichier de compte
                        </span>
                    </div>
                    <div class="card-body" style="padding:0px !important;">
                        <div class="col-md-12" style="padding:30px;">
                            {!! Form::open(array('url' => URL::to('operations/dropzone'), 'method' => 'post', 'id'=>'myDropzone','class' => 'dropzone', 'files'=> true)) !!}
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
	    <div class="col-lg-12">
		<div class="card ">
                    <div class="card-header bg-primary text-white ">
                        <span>
                            <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#fff" data-hc="#fff"></i> Hummm un graphique 
                        </span>
                        <span class="float-right">
                        <i class="fa fa-chevron-up showhide clickable"></i>
                        <i class="fa fa-times removepanel clickable"></i>
                    </span>
                    </div>
                    <div class="card-body">
                        <div class="app">
                            {!! $bar->html() !!}
                        </div>
                        <!-- End Of Main Application -->

                    </div>
                </div>
	    </div>
        </div>
    </section>
<section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-7">
            <div class="card ">
                <div class="card-header bg-primary text-white ">
                    <span> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Opérations compte commun
                    </span>
                    <!-- Modal -->
                            <div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title" id="myModalLabel">Form Modal</h4>
                                            <button type="button" class="close resetModal" data-dismiss="modal"
                                                    aria-hidden="true">×
                                            </button>
                                        </div>
                                        <div class="modal-body">

					    <div id="addCatDiv" style="display:none">
                                            	<form role="form" method="POST" action="#" id="addCatForm">
                                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                	<div class="form-group input-group">
                                                        	<label class="control-label" for="name">Nom categorie</label>
								<div class="input-group">
                                                        		<input type="text" class="form-control" name="catName" id="catName">
                                                        	</div>
							
						        </div>
							<div class="form-group input-group">
                                                                <label class="control-label" for="name">Categorie parente</label>
                                                                <div class="input-group">
									<select name="id_parent" id="id_parent">
										<option value="0">Aucune</option>
										@foreach($categories as $category)
											<option value="{!! $category->id!!}">{!! $category->name !!}</option>
										@endforeach
									</select>
                                                                </div>

                                                        </div>
							<div class="row marginTop">
                                                    		<div class="col-12 col-md-12">
                                                        		<input type="submit" id="addCatSubmitBtn" value="Enregistrer"
                                                              			 class="btn btn-primary btn-block btn-md btn-responsive"
                                                               			tabindex="7">
                                                    		</div>
                                                	</div>
						</form>
					    </div>
                                            <form role="form" method="POST" action="{!! route('operation_type.add') !!}" id="catForm" class="row" style="padding:10px;">
                                                <input type="hidden" id="addCatToken" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="catForm_id_operation" name="id_operation" value="0">
                                                <input type="hidden" id="catForm_id_operation_inc" name="id_operation_inc" value="0">
                                                <input type="hidden" id="catForm_id_operation_type" name="id_operation_type" value="0">
                                                <div class="form-group input-group col-lg-6">
                                                        <label class="control-label" for="name">Categories <button type="button" class="btn btn-success btn-xs" id="addCatBtn">Ajouter</button></label>
                                                        <div class="input-group">
							<ul>
							@foreach($categories as $category)
								
								<li>
									<div class="form-check abc-radio abc-radio-{!! $category->id !!} level1">
									    <span>{!! $category->icon !!}</span>
							                    <input class="form-check-input" type="radio" name="id_category" id="cat_{!! $category->id!!}" value="{!! $category->id !!}">
							                    <label class="form-check-label" for="cat_{!! $category->id!!}">
							                        {!! $category->name !!}  
							                    </label>
									    <i class="fas fa-plus-square" id="plus_{!! $category->id !!}" name="{!! $category->id !!}"></i>
									    <i class="fas fa-minus-square" id="minus_{!! $category->id !!}" name="{!! $category->id !!}" style="display:none;"></i>
							                </div>
								<ul id="parent_{!! $category->id !!}" class="subCat" style="display:none">
								@foreach($category->childs as $cat)
									<li>
										<div class="form-check abc-radio abc-radio-{!! $cat->id_parent !!} level2">
									    	    <span>{!! $cat->icon !!}</span>
	                                                                            <input class="form-check-input" type="radio" name="id_category" id="cat_{!! $cat->id!!}" value="{!! $cat->id !!}">
	                                                                            <label class="form-check-label" for="cat_{!! $cat->id!!}">
	                                                                                {!! $cat->name !!}
	                                                                            </label>
	                                                                        </div>
									</li>	
								@endforeach
								</ul>
								</li>
							@endforeach
							</ul>
                                                        </div>
                                                </div>
						<div class="form-group input-group col-lg-6">
							<div class="form-group input-group">
                                                                <label class="control-label" for="catForm_name">Nom opération</label>
                                                                <div class="input-group">
                                                                        <input type="text" class="form-control" name="name" id="catForm_name">
                                                                </div>

                                                        </div>
							<div class="form-group input-group">
                                                                <label class="control-label" for="name">texte à trouver</label>
                                                                <div class="input-group">
                                                                        <input type="text" class="form-control" name="findme" id="catForm_findme">
                                                                	<span id="operation_texte" style="color:black;font-size:14px;"></span>
								</div>

                                                        </div>
						</div>
                                                <div class="row marginTop">
                                                    <div class="col-12 col-md-12">
                                                        <input type="submit" id="catForm_submit" value="Enregistrer"
                                                               class="btn btn-primary btn-block btn-md btn-responsive"
                                                               tabindex="7">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
			
                </div>
                <br />
                <div class="card-body">
                    <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                    <table class="table table-bordered width100" id="operationsTable" style="width:100%">
                        <thead>
                        <tr class="filters">
                            <th>Date</th>
                            <th>Origine</th>
                            <th>Detail</th>
                            <th>Montant</th>
                            <th>Pointé</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
			<tfoot>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				</tr>
			</tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
	<div class="col-5">
            <div class="card ">
                <div class="card-header bg-primary text-white ">
                    <span> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Opérations à venir
                    </span>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-sm" id="addOperationInc" data-toggle="modal" data-target="#myModal">Ajouter une opération</button>
                    </div>
                    <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title" id="myModalLabel">Form Modal</h4>
                                            <button type="button" class="close resetModal" data-dismiss="modal"
                                                    aria-hidden="true">×
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{!! route('operations.add') !!}" id="form-validation3">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id_operation_inc" value="0">

                                                <div class="form-group">
                                                        <label for="alt">Date de l'opération</label>
                                                        <div class="input-group">
                                                                <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="livicon" data-name="calendar" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i></span>
                                                                </div>
                                                                <input class="form-control flatpickr" name="date" data-dateFormat=" F j, Y" id="alt" value="{{ date('Y-m-d') }}"/>
                                                        </div>
                                                </div>
						<div class="form-group">
                                                        <label class="control-label" for="selectize3">Cherchez le type d'opération</label>
                                                        <select id="selectize3" name="id_operation_type" class="form-control">
                                                                <option value="">Exemple : brico / peage / eau vive ...</option>
                                                                @foreach($operationTypes as $operationType)
                                                                        <option value="{!! $operationType->id !!}">{!! $operationType->name !!}</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group input-group">
                                                        <label class="control-label" for="name">Nom de l'opération</label>
                                                        <div class="input-group">
                                                        <input type="text" class="form-control" name="name" placeholder="Seulement si vous n'avez pas trouvé le type">
                                                        </div>
                                                </div>
                                                <div class="form-group input-group minus_form_group" id="sign_form_group">
                                                        <div class="input-group-append" id="switch_sign">
                                                                <span class="input-group-text">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i><i style="display:none" class="fa fa-plus" aria-hidden="true"></i>
                                                                        <input type="hidden" value="-" name="sign" id="sign"/>
                                                                </span>
                                                        </div>
                                                        <input type="text" class="form-control" name="amount" placeholder="Montant">
							
                                                </div>
						<div class="form-group" id="delta">
                                                        à
                                                        <select name="delta" class="form-control">
                                                                <option value="0">0%</option>
                                                                <option value="5">5%</option>
                                                                <option value="10">10%</option>
                                                                <option value="15">15%</option>
                                                                <option value="20">20%</option>
                                                        </select>
							près <span id="delta_amount" style="display:none">(soit entre <span id="amount_minus"></span>€ et <span id="amount_maxi"></span>€)</span>
                                                </div>
                                                <div class="form-group" id="period">
                                                        <label class="control-label" for="period">Récurrence</label>
                                                        <select name="period" class="form-control">
                                                                <option value="none">Non</option>
                                                                <option value="month">Mensuel</option>
                                                                <option value="year">Annuel</option>
                                                        </select>
                                                </div>
						<div class="row marginTop">
                                                    <div class="col-12 col-md-12">
                                                        <input type="submit" id="btncheck" value="Enregistrer"
                                                               class="btn btn-primary btn-block btn-md btn-responsive"
                                                               tabindex="7">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                </div>
                <br />
		<div class="card-body">
                    <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                    <table class="table table-bordered width100" id="operationsIncTable" style="width:100%">
                        <thead>
                        <tr class="filters">
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Montant</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                                <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>


        </div><!-- row-->


    </section>





<!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
{!! Charts::scripts() !!}
{!! $bar->script() !!}
<!-- page level js starts-->
<script type="text/javascript" src="{{ asset('js/frontend/jquery.circliful.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/wow/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/dist/l10n/fr.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>

<script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/frontend/index.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('vendors/sifter/sifter.js') }}"></script>
<script language="javascript" type="text/javascript"
        src="{{ asset('vendors/microplugin/microplugin.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendors/selectize/js/selectize.min.js') }}"></script>
<!--page level js ends-->
    <script type="text/javascript" src="{{ asset('vendors/dropzone/js/dropzone.js') }}" ></script>
    <script>
        var FormDropzone = function() {
            return {
                //main function to initiate the module
                init: function() {
                    Dropzone.options.myDropzone = {
                        init: function() {
                            this.on("success", function(file,responseText) {
                                var obj = jQuery.parseJSON(responseText);
                                file.id = obj.id;
                                file.filename = obj.filename;
                                // Create the remove button
                                var removeButton = Dropzone.createElement("<button style='margin: 10px 0 0 15px;'>Remove file</button>");

                                // Capture the Dropzone instance as closure.
                                var _this = this;

                                // Listen to the click event
                                removeButton.addEventListener("click", function(e) {
                                    // Make sure the button click doesn't submit the form:
                                    e.preventDefault();
                                    e.stopPropagation();

                                    $.ajax({
                                        url: "file/delete",
                                        type: "DELETE",
                                        data: { "id" : file.id, "_token": '{{ csrf_token() }}' }
                                    });
                                    // Remove the file preview.
                                    _this.removeFile(file);
                                });

                                // Add the button to the file preview element.
                                file.previewElement.appendChild(removeButton);

                            });

                        }
                    }
                }
            };
        }();
        jQuery(document).ready(function() {
            FormDropzone.init();

	    $("#switch_sign").click(function() {
		$("#sign_form_group").toggleClass('minus_form_group plus_form_group');
		if ($("#sign_form_group .fa-minus").is(":hidden")) {
			$("#sign_form_group .fa-minus").show();
			$("#sign_form_group .fa-plus").hide();
			$("#sign").val("-");
		} else {
			$("#sign_form_group .fa-minus").hide();
			$("#sign_form_group .fa-plus").show();
			$("#sign").val("+");

		}
	    });
        });
	    $("#selectize3").selectize({
	    });
		flatpickr.localize(flatpickr.l10ns.fr);

		var calendars = flatpickr(".flatpickr", {
    "locale": "fr"  // locale for this instance only
});
    flatpickr(".calendar",{
    "locale": "fr"  // locale for this instance only
});


    </script>
<script type="text/javascript" src="{{ asset('vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $(function() {
            var table = $('#operationsTable').DataTable({
                processing: true,
                serverSide: true,
                bFilter: true,
		decimal: ",",
                bInfo: false,
                bPaginate: true,
		order: [[ 0, 'desc' ], [ 4, 'asc' ]],
                ajax: '{!! route('operations.data') !!}',
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'type', name: 'operation_type' },
                    { data: 'superDetail', name: 'detail' },
                    { data: 'amount', name: 'amount' },
                    { data: 'pointe', name: 'checked' }
                    //{ data: 'action', name: 'Actions',"bSearchable": false, "bSortable": false }
                ],
		initComplete: function () {
			var r = $('#operationsTable tfoot tr');

			    $('#operationsTable thead').append(r);
         	  this.api().columns().every(function () {
                	var column = this;
                	var input = document.createElement("input");
                	$(input).appendTo($(column.footer()).empty()).css('width', '100%')
                		.on('change', function () {
                    			column.search($(this).val()).draw();
                		});
            	  });
        	}
            });
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            });

	    var tableInc = $('#operationsIncTable').DataTable({
                processing: true,
                serverSide: true,
                bFilter: true,
                ajax: '{!! route('operations.dataInc') !!}',
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'name', name: 'name' },
                    { data: 'amount', name: 'amount' },
                    { data: 'misc', name: '' }
                ],
                initComplete: function () {
                        var r = $('#operationsIncTable tfoot tr');

                            $('#operationsIncTable thead').append(r);
                  this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty()).css('width', '100%')
                                .on('change', function () {
                                        column.search($(this).val()).draw();
                                });
                  });
                }
            });
            tableInc.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            });
	   
	    $(document).on('click', '.typeOp', function(e) { 
		
		e.preventDefault();
	        $.ajax({
	            method: 'GET',
	            context: this,
	            url: '{!! route('operation.gettofill') !!}',
	            data: 'id_operation=' + $(this).attr('name'),
	            dataType: "json"
	        })
	        .done(function(data) {
			$('#catForm_name').val(data.result.name);
			$('#catForm_findme').val(data.result.findme);
			$("input[name=id_category]:checked").attr('checked', false);
	                $('#cat_'+data.result.id_category).attr('checked', true);
			$('#parent_'+ data.result.id_parent).slideDown('fast');
			$('#operation_texte').html(data.result.detail);
	        })
	        .fail(function(data) {
	                alert('fail');
	                alert(data);
	            /*$.each(data.responseJSON, function (key, value) {
	                var input = '#formRegister input[name=' + key + ']';
	                $(input + '+small').text(value);
	                $(input).parent().addClass('has-error');
	            });*/
	        });
 
		$('#catForm_id_operation').val($(this).attr('name'));
		$('#catForm_id_operation_inc').val('0');
		//$('#operation_texte').append($('#texte_'+$(this).attr('name')).val());
            });

	    $(document).on('click', '.typeOpInc', function(e) { 
                
                e.preventDefault();
                $.ajax({
                    method: 'GET',
                    context: this,
                    url: '{!! route('operationinc.gettofill') !!}',
                    data: 'id_operation_inc=' + $(this).attr('name'),
                    dataType: "json"
                })
                .done(function(data) {
                        $('#catForm_name').val(data.result.name);
                        $('#catForm_findme').val(data.result.findme);
                        $("input[name=id_category]:checked").attr('checked', false);
                        $('#cat_'+data.result.id_category).attr('checked', true);
                        $('#parent_'+ data.result.id_parent).slideDown('fast');
                        $('#operation_texte').html(data.result.detail);
                })
                .fail(function(data) {
                        alert('fail');
                        alert(data);
                    /*$.each(data.responseJSON, function (key, value) {
                        var input = '#formRegister input[name=' + key + ']';
                        $(input + '+small').text(value);
                        $(input).parent().addClass('has-error');
                    });*/
                });
 
                $('#catForm_id_operation_inc').val($(this).attr('name'));
                $('#catForm_id_operation').val('0');
                //$('#operation_texte').append($('#texte_'+$(this).attr('name')).val());
            });

 
	    $(document).on('click', '#catForm i.fa-plus-square', function(e) {  

		$('#parent_'+$(this).attr('name')).slideDown('fast');
		$('#minus_'+$(this).attr('name')).show();
		$('#plus_'+$(this).attr('name')).hide();
	    });
	    $(document).on('click', '#catForm i.fa-minus-square', function(e) {  

                $('#parent_'+$(this).attr('name')).slideUp('fast');
                $('#minus_'+$(this).attr('name')).hide();
                $('#plus_'+$(this).attr('name')).show();
            });

	    $(document).on('click', '#addCatBtn', function(e) {  

                $('#addCatDiv').slideDown('fast');
            }); 
	    $(document).on('click', '.pointage', function(e) {  
        e.preventDefault();
        $.ajax({
            method: 'GET',
	    context: this,
            url: '{!! route('operations.pointe') !!}',
            data: 'id_operation=' + $(this).attr('id'),
            dataType: "json"
        })
        .done(function(data) {
		if (data.result == 1) {
			$(this).children().removeClass('level-empty').addClass('success');
		} else {
			$(this).children().removeClass('success').addClass('level-empty');
		}
            //$('.alert-success').removeClass('hidden');
            //$('#myModal').modal('hide');
        })
        .fail(function(data) {
		alert('fail');
		alert(data);
            /*$.each(data.responseJSON, function (key, value) {
                var input = '#formRegister input[name=' + key + ']';
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });*/
        });
    });
	$(document).on('click', '#addCatSubmitBtn', function(e) {  
        e.preventDefault();
        $.ajax({
	    headers: {
  		  'X-CSRF-TOKEN': $('#addCatToken').val()
  	    },
            method: 'POST',
            context: this,
            url: '{!! route('category.add') !!}',
            data: 'name=' + $('#catName').val()		
			+ '&id_parent=' + $('#id_parent').val(),
	    dataType: "json"
        })
        .done(function(data) {

		var new_li = '<li><div class="form-check abc-radio abc-radio-'+$('#id_parent').val()+' level2">';
                new_li += '<span></span>';
		new_li += '<input class="form-check-input" type="radio" name="id_category" id="cat_'+data.result+'" value="'+data.result+'">';
		new_li += '<label class="form-check-label" for="cat_'+data.result+'">';
		new_li += $('#catName').val();
		new_li += '</label></div></li>';

		$("#parent_"+$('#id_parent').val()).append(new_li);
		$("input[name=id_category]:checked").attr('checked', false);
		$('#cat_'+data.result).attr('checked', true);
		$('#addCatDiv').slideUp('fast');
		$('.subCat').slideUp('fast');
		$("#parent_"+$('#id_parent').val()).slideDown('fast');
		
        })
        .fail(function(data) {
                alert('fail');
                alert(data);
            /*$.each(data.responseJSON, function (key, value) {
                var input = '#formRegister input[name=' + key + ']';
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });*/
        });
    });
/*
	$(document).on('click', '#catForm_submit', function(e) {  
        e.preventDefault();
        $.ajax({
            headers: {
                  'X-CSRF-TOKEN': $('#addCatToken').val()
            },
            method: 'POST',
            context: this,
            url: '{!! route('operation_type.add') !!}',
            data: 'id_operation='+$('#catForm_id_operation').val()+'&id_operation_type='+$('#catForm_id_operation_type').val()+'&id_category='+$("input[name=id_category]:checked").val()+'&name=' + $('#catForm_name').val()         
                        + '&findme=' + $('#catForm_findme').val(),
            dataType: "json"
        })
        .done(function(data) {

		window.location.replace("http://comptes.verschu.fr");

                var new_li = '<li><div class="form-check abc-radio abc-radio-'+$('#id_parent').val()+' level2">';
                new_li += '<span></span>';
                new_li += '<input class="form-check-input" type="radio" name="id_category" id="cat_'+data.result+'" value="'+data.result+'">';
                new_li += '<label class="form-check-label" for="cat_'+data.result+'">';
                new_li += $('#catName').val();
                new_li += '</label></div></li>';

                $("#parent_"+$('#id_parent').val()).append(new_li);
                $("input[name=id_category]:checked").attr('checked', false);
                $('#cat_'+data.result).attr('checked', true);
                $('#addCatDiv').slideUp('fast');
                $('.subCat').slideUp('fast');
                $("#parent_"+$('#id_parent').val()).slideDown('fast');
                
        })
        .fail(function(data) {
                alert('fail');
                alert(data);
            $.each(data.responseJSON, function (key, value) {
                var input = '#formRegister input[name=' + key + ']';
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });
        });
	
    });*/


	function fillModal(id_operation_inc) {

	        $.ajax({
	            method: 'GET',
	            context: this,
	            url: '{!! route('operations.getOperationInc') !!}',
	            data: 'id_operation_inc=' + id_operation_inc,
	            dataType: "json"
	        })
	        .done(function(data) {
	                if (data.id_operation_inc > 0) {
				//$('form#form-validation3 option').remove();
				$('form#form-validation3 input[name="id_operation_inc"]').val(data.id_operation_inc);
				$('form#form-validation3 input[name="date"]').val(data.date);
				$('form#form-validation3 input[name="sign"]').val(data.sign);
				$('form#form-validation3 select#selectize3 option').remove();
				$('form#form-validation3 select#selectize3').append('<option selected="selected" value="'+data.id_operation_type+'">'+data.operation_type_name+'</option>');
				$('.selectize-control .selectize-input div.item').remove();
				$('.selectize-control .selectize-input').prepend('<div class="item" data-value="'+data.id_operation_type+'">'+data.operation_type_name+'</div>');
				$('#selectize3-selectized').removeAttr('placeholder');
				$('form#form-validation3 input[name="amount"]').val(data.amount);
				if (data.sign == "+") {
					if ($("#sign_form_group").hasClass('minus_form_group')) {
						$("#sign_form_group").toggleClass('minus_form_group plus_form_group');
						$("#sign_form_group .fa-minus").hide();
			                        $("#sign_form_group .fa-plus").show();
					}
				} else {
					if ($("#sign_form_group").hasClass('plus_form_group')) {
						$("#sign_form_group").toggleClass('minus_form_group plus_form_group');
						$("#sign_form_group .fa-minus").show();
			                        $("#sign_form_group .fa-plus").hide();
					}

				}
				$('form#form-validation3 #delta select option[value="'+data.delta+'"]').prop('selected', true);
				$('form#form-validation3 option[value="'+data.period+'"]').prop('selected', true);
	                } else {
				$('form#form-validation3 input[name="id_operation_inc"]').val(0);
				var today = new Date();
				var dd = String(today.getDate()).padStart(2, '0');
				var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
				var yyyy = today.getFullYear();

                                $('form#form-validation3 input[name="date"]').val(yyyy+'-'+mm+'-'+dd);
                                $('form#form-validation3 input[name="sign"]').val('-');
                                $('form#form-validation3 select#selectize3 option').remove();
                                $('.selectize-control .selectize-input div.item').remove();
                                $('#selectize3-selectized').attr('placeholder', 'Exemple : brico / peage / eau vive ...');
                                $('form#form-validation3 input[name="amount"]').val('');
                                        if ($("#sign_form_group").hasClass('plus_form_group')) {
                                                $("#sign_form_group").toggleClass('minus_form_group plus_form_group');
                                                $("#sign_form_group .fa-minus").show();
                                                $("#sign_form_group .fa-plus").hide();
                                        }

                                $('form#form-validation3 #delta select option[value="0"]').prop('selected', true);
                                $('form#form-validation3 option[value="none"]').prop('selected', true);

			} 
	        })
	        .fail(function(data) {
	                alert('fail');
	                alert(data);
	            
	        }); 
		
	}

	$(document).on('change', '#delta select', function(e) {
	
		var delta = parseInt($('#delta select').val());		

		if (delta > 0) {
			var amount = parseFloat($('form#form-validation3 input[name="amount"]').val());
			var amount_min = amount - (amount/100*delta);
			var amount_maxi = amount + ((amount/100)*delta);
			$('#amount_minus').html(amount_min.toFixed(2));
			$('#amount_maxi').html(amount_maxi.toFixed(2));
			$('#delta_amount').show();
		} else {
			$('#delta_amount').hide();
		}
	});
	$(document).on('click', '.editInc', function(e) {
		fillModal($(this).attr('name'));
	}); 
	$(document).on('click', '#addOperationInc', function(e) {
		fillModal(0);
	}); 
	$(document).on('click', '.deleteInc', function(e) {  
        e.preventDefault();
	var confirmation = confirm('Etes vous sur de vouloir supprimer cette opération ?');
	if (confirmation) {
        $.ajax({
            method: 'GET',
            context: this,
            url: '{!! route('operations.deleteInc') !!}',
            data: 'id_operation_inc=' + $(this).attr('name'),
            dataType: "json"
        })
        .done(function(data) {
                if (data.result == 1) {
                        $(this).parent().parent().remove();
                } 
            //$('.alert-success').removeClass('hidden');
            //$('#myModal').modal('hide');
        })
        .fail(function(data) {
                alert('fail');
                alert(data);
            /*$.each(data.responseJSON, function (key, value) {
                var input = '#formRegister input[name=' + key + ']';
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });*/
        });
	}
    });

	$(document).on('click', '.renewInc', function(e) {  
	        e.preventDefault();
	var confirmation = confirm('Etes vous sur de vouloir supprimer occurence ? l operation reviendra pour l echeance suivante');
	if (confirmation) {
	        $.ajax({
	            method: 'GET',
	            context: this,
	            url: '{!! route('operations.renewInc') !!}',
	            data: 'id_operation_inc=' + $(this).attr('name'),
	            dataType: "json"
	        })
	        .done(function(data) {
	                if (data.result == 1) {
	                        $(this).parent().parent().remove();
	                } 
	            //$('.alert-success').removeClass('hidden');
	            //$('#myModal').modal('hide');
	        })
	        .fail(function(data) {
	                alert('fail');
	                alert(data);
	            /*$.each(data.responseJSON, function (key, value) {
	                var input = '#formRegister input[name=' + key + ']';
	                $(input + '+small').text(value);
	                $(input).parent().addClass('has-error');
	            });*/
	        });
	}
	});

        });
    </script>
@stop


