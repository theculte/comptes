@extends('layouts/default')

{{-- Page title --}}
@section('title')
Home
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css starts-->
<link type="text/css" rel="stylesheet" href="{{ asset('css/pages/flot.css') }}" />
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
            <div class="col-lg-12">
		<!-- Stack charts strats here-->
                <div class="card ">
                    <div class="card-header bg-primary text-white ">
                        <span>
                            <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#fff" data-hc="#fff"></i> Dépenses
                        </span>
                        <span class="float-right">
                        <i class="fa fa-chevron-up showhide clickable"></i>
                        <i class="fa fa-times removepanel clickable"></i>
                    </span>
                    </div>
                    <div class="card-body">
                        <div class="app">
                            {!! $line->html() !!}
                        </div>
                        <!-- End Of Main Application -->
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
{!! $line->script() !!}
<!-- page level js starts-->

<script type="text/javascript" src="{{ asset('js/frontend/jquery.circliful.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/wow/js/wow.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/frontend/index.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('vendors/sifter/sifter.js') }}"></script>
<script language="javascript" type="text/javascript"
        src="{{ asset('vendors/microplugin/microplugin.js') }}"></script>

@stop


