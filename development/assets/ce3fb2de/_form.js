var fileInput = document.getElementById('image');
var dropZone = document.getElementById('drop_zone');

function link_adder(id) {
	var html = '<div class="well" id="' + random_hash_name + '"><a class="ui-icon ui-icon-close pull-right" onclick="$(this).parent().remove();"></a><label>Label</label><input type="text" class="input-block-level" name="links[new][' + cfg.link_counter + '][label]" required="required" value="Buy Tickets" /><label>Ticketing Link</label><input type="text" class="input-block-level" name="links[new][' + cfg.link_counter + '][href]" required="required" rel="tooltip" data-placement="right" title="Input full URL including http:// or https://" /><input type="hidden" name="links[new][' + cfg.link_counter + '][productionVenueID]" value="' + id + '"/></div>';
	var random_hash_name = 'field_' + Math.floor((Math.random() * 10000) + 1);
	cfg.link_counter++;
	$("#ticketinglinks_" + id).append(html);
}

function production_adder() {
	var random_hash_name = 'field_' + Math.floor((Math.random() * 10000) + 1);
	var html = '<div class="well" id="' + random_hash_name + '"><a class="ui-icon ui-icon-close pull-right" onclick="$(this).parent().remove();"></a><label>Show</label><input id="tb_showName_' + random_hash_name + '" type="text" name="production[new][' + cfg.production_counter + '][showName]" required="required" rel="tooltip" data-placement="right" title="Input a minimum of 3 characters to receive suggestions" /><label>Production</label><select id="productionID_' + random_hash_name + '" type="hidden" name="production[new][' + cfg.production_counter + '][productionID]"><option value="0">Select</option></select><label>Start date</label><input id="production_start_' + random_hash_name + '" type="text" name="production[new][' + cfg.production_counter + '][startDate]" rel="tooltip" title="MM-DD-YYYY" data-placement="right"><label>End date</label><input id="production_end_' + random_hash_name + '" type="text" name="production[new][' + cfg.production_counter + '][endDate]" rel="tooltip" title="MM-DD-YYYY" data-placement="right" /><input id="showID_' + random_hash_name + '" type="hidden" name="production[new][' + cfg.production_counter + '][showID]" value="0" /></div>';
	cfg.production_counter++;
	$('#production_container').prepend(html);
	$("#production_start_" + random_hash_name).datepicker({
		dateFormat: "mm-dd-yy"
	});
	$("#production_end_" + random_hash_name).datepicker({
		dateFormat: "mm-dd-yy"
	});
	$("#tb_showName_" + random_hash_name).autocomplete({
		//source: "<?php echo yii::app()->createUrl('People/ProductionLists') ?>",
		source: cfg.showBaseUrl+'/ShowLists',
		minLength: 3,
		select: function(event, ui) {
			$("#showID_" + random_hash_name).val(ui.item.id);
			$.getJSON(cfg.venueBaseUrl+'/ProductionLists', {showID: ui.item.id}, function(data) {
				$('#productionID_' + random_hash_name).empty();
				$('#productionID_' + random_hash_name).append(new Option("Select", 0));
				$('#productionID_' + random_hash_name).append(new Option("Create new production", 0));
				$.each(data, function() {
					$('#productionID_' + random_hash_name).append(new Option(this.value, this.id));
				});
			});
		},
		change: function(event, ui) {
			if (!ui.item) {
				$("#showID_" + random_hash_name).val(0);
				$('#productionID_' + random_hash_name).empty();
				$('#productionID_' + random_hash_name).append(new Option("Select", 0));
				$('#productionID_' + random_hash_name).append(new Option("Create new production", 0));
			}
		}
	})
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
							var maxWidth = 500;
							var maxHeight = 300;
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
								aspectRatio: 5 / 3,
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

$(".ui-icon.edit").click(function() {
	$(this).parent().addClass("hide");
	$(this).parent().next().removeClass("hide");
});

$(".ui-icon.editCancel").click(function() {
	$(this).parent().addClass("hide");
	$(this).parent().prev().removeClass("hide");
});
$(document).on('focus', "[data-exttype='date']", function() {
	$(this).datepicker({
		dateFormat: "mm-dd-yy"
	});
});

$(document).on('focus', "[data-autocomplete='show']", function() {
	$(this).autocomplete({
		source: cfg.showBaseURL+'/ShowLists',
		minLength: 3,
		select: function(event, ui) {
			element = $(this);
			element.siblings("input[id^='showID_']").val(ui.item.id);
			if (element.siblings("select[id^='productionID_']").length > 0) {
				$.getJSON(cfg.venueBaseUrl+'/ProductionLists', {showID: ui.item.id}, function(data) {
					element.siblings("select[id^='productionID_']").empty();
					element.siblings("select[id^='productionID_']").append(new Option("Select", 0));
					element.siblings("select[id^='productionID_']").append(new Option("Create new production", 0));
					$.each(data, function() {
						element.siblings("select[id^='productionID_']").append(new Option(this.value, this.id));
					});
				});
			}
		},
		change: function(event, ui) {
			if (!ui.item) {
				element.siblings("input[id^='showID_']").val(0);
				if (element.siblings("select[id^='productionID_']").length > 0) {
					element.siblings("select[id^='productionID_']").empty();
					element.siblings("select[id^='productionID_']").append(new Option("Select", 0));
					element.siblings("select[id^='productionID_']").append(new Option("Create new production", 0));
				}
			}
		}
	});
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