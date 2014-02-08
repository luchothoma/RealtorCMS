@extends('panel.panel')
@section('head')
@endsection
@section('panel')
<div id="form">
	<div class="input-group">
		<span class="input-group-addon">Link Property</span>
		<input type="text" id="prop_url"class="form-control" placeholder="Example: http://franco.encom.uy/-nbsp-5519-lynbrook-dr--houston--tx-77056-/3" required />
	</div>
	<button id="getData" type="button" class="btn btn-danger btn-sm" style="margin-top:5px;">Obtener Datos !</button>
	<button class="example btn btn-primary" data-href="http://franco.encom.uy/-nbsp-5519-lynbrook-dr--houston--tx-77056-/3">Ejemplo 1</button> 
	<button class="example btn btn-primary" data-href="http://franco.encom.uy/-nbsp-4033-university-blvd--west-university--tx-77005-/1">Ejemplo 2</button>
	<div id="msjs"></div>
	<div id="data"class="hide">
		<div id="fileuploader">Subir</div>
		<h3 style="text-align:center;">INFORMATION</h3>
	    <div>
	        <label>Permanent Link - domain.com/whatyouput/PropertyWebId</label>
	        <input type="text" class="form-control extract" id="permlink" value="" required>
	    </div>
  		<div>
  			<label>Description English</label>
	        <textarea class="form-control extract" id="description" rows="5"></textarea>
	    </div>
		<div>
			<label>Description Spanish</label>
	        <textarea class="form-control extract" id="descriptionEs" rows="5" placeholder="Write spanish description, please."></textarea>
	    </div>				
		<div>
			<label>City-Area</label>
	        <input type="text" class="form-control extract" id="mrkt_area" value="" required />
	    </div>
		<div>
			<label>Address</label>
	        <input type="text" class="form-control extract" id="address" value="" required />
	    </div>
		<div>
			<label>Price</label>
	        <input type="text" class="form-control extract" id="price" value="" required />
	       </div>
		<div>
			<label>Building SquareFeet</label>
	          <input type="text" class="form-control extract" id="ft" value="" required="">
	    </div>
	    <div>
	    	<label>Building SquareMeter</label>
	    	<input type="text" class="form-control extract" id="m2" value="" required />
	    </div>
	    <div>
	        <label>Build Year</label>
	        <input type="text" class="form-control extract" id="year_built" value="" required="">
	    </div>
	    <div>
	        <label>Beedrooms</label>
	        <input type="text" class="form-control extract" id="bedrooms" value="" required />
	    </div>
	    <div>
	        <label>Baths</label>
	        <input type="text" class="form-control extract" id="baths" value="" required />
	    </div>
	    <div>
	        <label>Garage</label>
	        <input type="text" class="form-control extract" id="garage" value="" required />
	    </div>
	    <div>
	       	<label>Swimming Pool</label>
	        <input type="text" class="form-control extract" id="swimming_pool" value="" required="">
	    </div>
	    <div>
	       	<label>School District</label>
	        <input type="text" class="form-control extract" id="district" value="" required />
	    </div>
	    <div>
	        <label>Elementary School</label>
	        <input type="text" class="form-control extract" id="elementaryl" value="" required />
	    </div>
	    <div>
	        <label>Middle School</label>
	        <input type="text" class="form-control extract" id="middle" value="" required />
	    </div>
	    <div>
	       	<label>High School</label>
	        <input type="text" class="form-control extract" id="high" value="" required />
	    </div>
	    <div>
	       	<label>HAR Reference Link</label>
	        <input type="text" class="form-control extract" id="ref_url" value="" required />
	    </div>
	    <div id='gallery'></div>
	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
			<div class="btn-group" style="margin-top:5px;">
	        	<a id="saveIt" class="btn btn-success">Save Property</a>
  				<a id="cancel" class="btn btn-primary">Cancel</a>
  			</div>
  		</div>
		<script>
		$.ajax({
			url: '/admin/edit',
			type: 'post',
			dataType: 'json',
			timeout: 15000,
			data: 'prop_url='
		}).done(function(a){
			
		}).fail(function(){

		});
		</script>
	</div>
	<!--Este div corrije el error de flotacion de las imagenes en la galeria-->
	<div class="clearfix"></div>
</div>
{{ HTML::script('/js/panel.add.js') }}
@endsection