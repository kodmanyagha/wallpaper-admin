@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => $titlePage])

@section('content')


<div class="content">
	<form method="post" enctype="multipart/form-data" action="" autocomplete="off" class="form-horizontal">
		@csrf
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card ">
						<div class="card-header card-header-primary">
							<h4 class="card-title">{{ $titlePage }}</h4>
						</div>
						<div class="card-body ">
							@if (session('status'))
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="material-icons">close</i>
										</button>
										<span>{{ session('status') }}</span>
									</div>
								</div>
							</div>
							@endif
							
							<div class="row">
								<div class="col-sm-2">

<div id="accordion" class="form-elements">
	<div class="m-0 p-0">
		<div class="m-0 p-0" id="headingOne">
			<button type="button" class="btn btn-block btn-success" data-toggle="" aria-expanded="true"
					data-target="#collapseHtml" aria-controls="collapseHtml">
				HTML
			</button>
		</div>
		<div id="collapseHtml" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="list-group" id="list1" class="" aria-labelledby="headingOne" data-parent="#leftAccordion">
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplHeader">
					<i class="fas fa-heading"></i>&nbsp;&nbsp;
					Başlık
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplParagraph">
					<i class="fas fa-paragraph"></i>&nbsp;&nbsp;
					Paragraf
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-list"></i>&nbsp;&nbsp;
					Liste
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-heading"></i>&nbsp;&nbsp;
					Başlık
				</a>
			</div>
		</div>
	</div>
	<div class="m-0 p-0">
		<div class="m-0 p-0" id="headingOne">
			<button type="button" class="btn btn-block btn-success" data-toggle="" aria-expanded="true"
					data-target="#collapseForm" aria-controls="collapseForm">
				FORM
			</button>
		</div>
		<div id="collapseForm" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="list-group" id="list1" class="" aria-labelledby="headingOne" data-parent="#leftAccordion">
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplInput">
					<i class="fas fa-font"></i>
					&nbsp;&nbsp; Metin (input)
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplTextarea">
					<i class="far fa-file-alt"></i>
					&nbsp;&nbsp; Çok Satırlı (textarea)
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplInput">
					<i class="fas fa-check-circle"></i>
					&nbsp;&nbsp; Tekli Seç (radiobox)
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplInput">
					<i class="fas fa-check-square"></i>
					&nbsp;&nbsp; Çoklu Seç (checkbox)
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="far fa-calendar-plus"></i>
					&nbsp;&nbsp; Tarih
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-clock"></i>
					&nbsp;&nbsp; Saat
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-calendar-check"></i>
					&nbsp;&nbsp; Tarih ve Saat
				</a>
			</div>
		</div>
	</div>
</div>
								</div>
								<div class="col-sm-7">

<div class="row" style="border: 1px solid #cccccc; border-radius: 5px; background: #fafafa;">
	<div class="col-12">
		<div class="form-designer-container">
			<div class="row">
				<div class="col-12 text-center">
					<h1>Form</h1>
					<hr />
				</div>
				<div class="col-12 p-0">

<ul id="sortable" class="list-group list-group-flush" style="min-height: 200px;">
</ul>

				</div>
				<div class="col-12">
					<br />
				</div>
				
				<div class="col-12">
					<button class="btn btn-success btn-block" type="button">
						<i class="far fa-paper-plane"></i>
						&nbsp;&nbsp;
						FORMU GÖNDER
					</button>
				</div>
			</div>
			<br />
		</div>
	</div>
</div>

								</div>
								<div class="col-sm-3">
<div id="propertiesSidebar" class="form-elements">
	<div class="m-0 p-0">
		<div class="m-0 p-0" id="headingOne">
			<button type="button" class="btn btn-block btn-success" data-toggle="" aria-expanded="true"
					data-target="#collapseHtml" aria-controls="collapseHtml">
				ÖZELLİKLER
			</button>
		</div>
		<div id="collapseHtml" class="collapse show" aria-labelledby="headingOne" data-parent="#propertiesSidebar">
			<div class="list-group" id="list1" class="" aria-labelledby="headingOne" data-parent="#leftAccordion">
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplHeader">
					<i class="fas fa-heading"></i>&nbsp;&nbsp;
					Başlık
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action"
					data-template-id="tplParagraph">
					<i class="fas fa-paragraph"></i>&nbsp;&nbsp;
					Paragraf
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-list"></i>&nbsp;&nbsp;
					Liste
				</a>
				<a href="javascript:;" class="draggable-form-element list-group-item list-group-item-action">
					<i class="fas fa-heading"></i>&nbsp;&nbsp;
					Başlık
				</a>
			</div>
		</div>
	</div>
</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<button type="submit" id="btnSubmit" class="btn btn-success btn-block btn-lg">
						<i class="fas fa-save"></i>&nbsp;&nbsp;{{ __('Kaydet') }}
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@push('js')

<script src="https://unpkg.com/mustache@latest"></script>

<script>
$(document).ready(function() {
	  tinymce.init({
		    selector: 'textarea.content-editor',
		    //skin: 'bootstrap',
		    plugins: 'lists, link, image, media',
		    toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
		    menubar: false,
		    height : "480"
		  });
});
</script>

<style>
#sortable .list-group-item {
	border: 2px solid #ffffff00;
	padding: 20px 20px 20px 20px;
	margin: 5px 0px 5px 0px;
	border-radius: 5px;
}
#sortable .list-group-item:hover {
	border: 2px solid #ff000044;
}

#sortable .selected {
	border: 2px solid #ff0000 !important;
}

</style>




<script id="tplHeader" type="x-tmpl-mustache">
<li class="list-group-item" id="{[ id ]}">
	<input type="hidden" data-type="form_input_text">
	<input type="hidden" data-name="title" value="Başlığı buraya yazınız.">

	<div class="row">
		<div class="col-11">
			<h1 name="title"></h1>
		</div>
		<div class="col-1 move-handler text-center" style="cursor: pointer; padding-top: 5px;">
			<i class="fas fa-arrows-alt-v fa-2x"></i>
			<span style="color: red;" onclick="deleteElem( '{[ id ]}' )">
				<i class="fas fa-trash fa-2x"></i>
			</span>
		</div>
	</div>
</li>
</script>

<script id="tplParagraph" type="x-tmpl-mustache">
<li class="list-group-item" id="{[ id ]}">
	<input type="hidden" data-type="form_input_text">
	<input type="hidden" data-name="content" value="İçeriği yazınız.">

	<div class="row">
		<div class="col-11">
			<p name="content"></p>
		</div>
		<div class="col-1 move-handler text-center" style="cursor: pointer; padding-top: 5px;">
			<i class="fas fa-arrows-alt-v fa-2x"></i>
			<span style="color: red;" onclick="deleteElem( '{[ id ]}' )">
				<i class="fas fa-trash fa-2x"></i>
			</span>
		</div>
	</div>
</li>
</script>

<script id="tplInput" type="x-tmpl-mustache">
<li class="list-group-item" id="{[ id ]}">
	<input type="hidden" data-type="form_input_text">
	<input type="hidden" data-name="title" value="Başlık">
	<input type="hidden" data-name="description" value="Lütfen buraya açıklamayı yazınız.">

	<div class="row">
		<div class="col-11">
				<div class="form-group">
					<label name="title"></label>
					<input type="text" name="title" class="form-control" placeholder="">
					<small class="form-text text-muted" name="description"></small>
				</div>
		</div>
		<div class="col-1 move-handler text-center" style="cursor: pointer; padding-top: 5px;">
			<i class="fas fa-arrows-alt-v fa-2x"></i>
			<span style="color: red;" onclick="deleteElem( '{[ id ]}' )">
				<i class="fas fa-trash fa-2x"></i>
			</span>
		</div>
	</div>
</li>
</script>

<script id="tplTextarea" type="x-tmpl-mustache">
<li class="list-group-item" id="{[ id ]}">
	<input type="hidden" data-type="form_input_textarea">
	<input type="hidden" data-name="title" value="Başlık">
	<input type="hidden" data-name="content" value="Başlık">
	<input type="hidden" data-name="description" value="Lütfen buraya açıklamayı yazınız.">

	<div class="row">
		<div class="col-11">
				<div class="form-group">
					<label name="title"></label>
					<textarea name="content" placeholder="" class="form-control" rows="4"></textarea>
					<small class="form-text text-muted" name="description"></small>
				</div>
		</div>
		<div class="col-1 move-handler text-center" style="cursor: pointer; padding-top: 5px;">
			<i class="fas fa-arrows-alt-v fa-2x"></i>
			<span style="color: red;" onclick="deleteElem( '{[ id ]}' )">
				<i class="fas fa-trash fa-2x"></i>
			</span>
		</div>
	</div>
</li>
</script>





<script>
function deleteElem(id) {
	if ( confirm('Emin misiniz?') )
		$('#' + id).remove();
}
function onListGroupItemClick(event, elem) {
	$('#sortable .list-group-item').removeClass('selected')
	elem.addClass('selected')
}
function makeId(length) {
	var result           = '';
	var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

$( function() {
	window.newElement = null;
	var customTags = [ '{[', ']}' ];
	Mustache.tags = customTags

	$('#sortable .list-group-item').on('click', function(event) {
		var elem =  $(this)
		onListGroupItemClick(event, elem);
	});
	
	$( "#sortable" ).sortable({
		revert: true,
		scrollSpeed: 100,
		axis: 'y',
		receive: function( event, ui ) {
			if ( window.newElement === null )
				return;

			var templateId = window.newElement.attr('data-template-id');
			var templateHtml = $('#' + templateId).html();
			var templateHtmlId = 'elem_' + makeId(4)
			var renderedHtml = Mustache.render(templateHtml, { id: templateHtmlId });
			
			window.newElement.after(renderedHtml);
			window.newElement.remove();

			var attachedItem = $('#' + templateHtmlId)
			var hiddenInputs = attachedItem.find('input[type=hidden]')
			
			for(var i = 0; i < hiddenInputs.length; i++) {
				var currentElem = $(hiddenInputs[i])
				if ( typeof currentElem.attr('data-name') == 'string' ) {
					var name = currentElem.attr('data-name')
					console.log(name)
					var hiddenVal = currentElem.val()
					var foundElems = attachedItem.find('*[name="'+ name +'"]')

					for (var j = 0; j < foundElems.length; j++) {
						var foundElem = $(foundElems[j])
						console.log(foundElem.prop("tagName"))
						
						if ( foundElem.prop("tagName").toLowerCase() == 'input' ) {
							foundElem.attr('placeholder', hiddenVal)
						}
						else if ( foundElem.prop("tagName").toLowerCase() == 'textarea' ) {
							foundElem.attr('placeholder', hiddenVal)
						}
						else {
							foundElem.html(hiddenVal)
						}
					}
				}
			}
			
			attachedItem.on('click', function(event) {
				var elem =  $(this)
				onListGroupItemClick(event, elem);
			});
			
			$('#btnSubmit').removeClass('btn-success');
			$('#btnSubmit').addClass('btn-danger');

			window.newElement = null;
		}
	});

	$( ".form-elements a.draggable-form-element" ).draggable({
		connectToSortable: "#sortable",
		revert: "invalid",
		//revert: false,
		connectToSortable: '#sortable',
		opacity: 0.8,
		helper: "clone",
		stop: function( event, ui ) {
			var newElement = $(ui.helper[0]);
			var oldElement = $(ui.helper.prevObject[0])
			window.newElement = newElement;
			
			setTimeout(function() {
				console.log(newElement)
				console.log(oldElement)
			}, 2000);
		}
	});
	
	$( "#sortable li > *" ).disableSelection();
} );
</script>

@endpush
