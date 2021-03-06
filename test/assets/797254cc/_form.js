var fileInput = document.getElementById('image');
var dropZone = document.getElementById('drop_zone');
function role_adder(id)
{
	var random_hash_name='field_'+Math.floor((Math.random() * 1000) + 1);
	var html='<div class="well" id="'+random_hash_name+'"><a class="ui-icon ui-icon-close pull-right" onclick="$(this).parent().remove();return 0;"></a><label>Enter Name</label><input type="text" id="tb_'+random_hash_name+'" name="new_creator['+cfg.creator_counter+'][name]" required="required" autocomplete="off" rel="tooltip" title="Format: First Middle Last Suffix; Input a minimum of 3 characters to receive suggestions"  data-placement="right"><input id="role_'+random_hash_name+'" type="hidden" name="new_creator['+cfg.creator_counter+'][role]" value="'+id+'" /><input id="individualID_'+random_hash_name+'" type="hidden" name="new_creator['+cfg.creator_counter+'][individualID]" value="0" /></div>';
	cfg.creator_counter++;
	$('#role_'+id).prepend(html);
	$( "#tb_"+random_hash_name ).autocomplete({
		source: cfg.showBaseUrl+'/'+'CreatorLists',
		minLength: 3,
		change: function( event, ui ) {
			$( "#individualID_"+random_hash_name ).val( ui.item? ui.item.id : 0 );
			setTimeout(function(){
			},1);
			//setTimeout(function(){
				//$( "#"+random_hash_name ).remove();},1);
				//var html2='<div class="well"><a href="javascript:void();" class="ui-icon ui-icon-close pull-right" onclick="$(this).parent().remove();"></a><strong>'+ui.item.value+'</strong><input type="hidden" name="creator['+ui.item.id+']" value="'+id+'" /></div>';
				//$('#role_'+id).prepend(html2);
			//}	
		}
	});
}

function updateCoordinates(cropbox) {
	$("#crop_x").val(cropbox.x);
	$("#crop_y").val(cropbox.y);
	$("#width").val(cropbox.w);
	$("#height").val(cropbox.h);
}

function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

function handleClick(evt) {
	$("#image").click();
};

function handleFileSelect(evt) {
	if (typeof evt.target.files != 'undefined') {
		var files = evt.target.files;
	} else {
		evt.stopPropagation();
		evt.preventDefault();
		var files = evt.dataTransfer.files;
		fileInput.files = files;
	}
	if (files.length != 0) {
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
			// Only process image files.
			if (!f.type.match('image.*')) {
				continue;
			}

			var reader = new FileReader();
			// Closure to capture the file information.
			reader.onload = (function(theFile) {
				return function(e) {
					// Render thumbnail. 
					var image = new Image();
					image.src = e.target.result;
					image.onload = function() {           
						$('#btnImgUpd').prop('disabled', true);
						if (cfg.jCropRef) cfg.jCropRef.destroy();
						$("#preview").html("");
						$("#pnlPreview").hide();
						$(".img-upload.alert.alert-error").hide();
						if (image.width > 1000 || image.height > 800) {
							$(".img-upload.alert.alert-error").html("Picture too large and cannot be processed. Please try uploading a smaller picture").show();
							//setTimeout(function() {
							//	$(".img-upload.alert.alert-error").hide('fadeout', {}, 500)
							//}, 3000);
						} else {
							alert(image.width);
							alert(image.height);
							var maxWidth = 280;
							var maxHeight = 440;
							if (image.width < maxWidth)
							{
								maxWidth = image.width;
							}
							if (image.height < maxHeight)
							{
								maxHeight = image.height;
							}
							var x1 = image.width / 2 - maxWidth / 2;
							var x2 = image.width / 2 + maxWidth / 2;
							var y1 = image.height / 2 - maxHeight / 2;
							var y2 = image.height / 2 + maxHeight / 2;
							alert(x1);alert(y1);alert(x2);alert(y2);
							var img = $('<img id="imgSrc" src="' + e.target.result + '"></img>');
							$("#preview").append(img);
							img.Jcrop({
								//onSelect:    showCoords,
								onChange: updateCoordinates,
								bgColor: 'black',
								bgOpacity: .4,
								//maxSize: [maxWidth, maxHeight],
								//minSize: [maxWidth, maxHeight],
								aspectRatio: 7 / 11,
								setSelect: [x1, y1, x2, y2],
								boxWidth: maxWidth,
								boxHeight: maxHeight,
							}, function() {
								cfg.jCropRef = this;
							});
							$('#btnImgUpd').prop('disabled', false);
							$("#pnlPreview").show();
						}
					}
				};
			})(f);

			reader.readAsDataURL(f);
		}
	}
}

fileInput.addEventListener('change', handleFileSelect, false);
dropZone.addEventListener('dragover', handleDragOver, false);
dropZone.addEventListener('drop', handleFileSelect, false);
dropZone.addEventListener('click', handleClick, false);

$("#btnImgUpd").click(function() {
	if (cfg.isNewRecord== 1) {
        var rx = $("#crop_x").val();
		var ry = $("#crop_y").val();
		var width = $("#width").val();
		var height = $("#height").val();
		var img = new Image();
		img.src = $("#imgSrc").attr("src");
		canvas = $('<canvas width="'+ width +'" height="'+ height +'"/>').appendTo('body').hide(),
        ctx = canvas.get(0).getContext('2d'),
		ctx.drawImage(img, rx, ry, width, height, 0, 0, width, height);
		var base64ImageData = canvas.get(0).toDataURL();
		$("#imgProfilePic").prop("src", canvas.get(0).toDataURL());
		canvas.remove();
	} else {
		$("#btnSubmit").click();
	}
});

$('[data-target="#myModal"]').click(function() {
	$("#preview").html("");
	$("#pnlPreview").hide();
	$("#image").val("");
	if (cfg.jCropRef) cfg.jCropRef.destroy();
});

$(document).on("click",".deleteConfirm",function(e){
	e.preventDefault();
    var location = $(this).attr('href');
	bootbox.confirm("Are you sure you want to delete this record?",function(result)
		{
			if(result)
				window.location.replace(location);
        });
});