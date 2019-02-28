$('.ckeditor').each(function(){
	let id_editor = $(this).attr('id');

	CKEDITOR.replace(id_editor, {
		htmlEncodeOutput : false,
		allowedContent : true,
		resize_minWidth: 200
	});
	
	let _this = CKEDITOR.instances[id_editor];
	
	/* to load when it has an already saved content */
	if(_this.getData()){
		$.ajax({
			url: "src/seo.php?v="+(new Date()).getTime(),
			type: "POST",
			data: {
				text: _this.getData()
			},
			dataType: "json",
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			success: function(ret){
				$('#snippet-'+id_editor+' > .snippet_preview-tips').html(ret.message);
			}
		});
	}
	
	/* to load when user types, using 1s of timeout to avoid flooding */
	_this.on('change', function() {
		setTimeout(function(){
			_this.updateElement();
			$.ajax({
				url: "src/seo.php?v="+(new Date()).getTime(),
				type: "POST",
				data: {
					text: _this.getData()
				},
				dataType: "json",
				contentType: "application/x-www-form-urlencoded;charset=utf-8",
				success: function(ret){
					$('#snippet-'+id_editor+' > .snippet_preview-tips').html(ret.message);
				}
			});
		},1000);
	});
});