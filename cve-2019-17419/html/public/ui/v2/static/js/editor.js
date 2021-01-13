/*
编辑器内容处理功能
 */
(function(){
	$(function(){
		// 编辑器响应式表格（需调用tablesaw插件）
		var $meteditor_table=$(".met-editor table");
		if($meteditor_table.length) $meteditor_table.tablexys();
		if(M.device_type=='m'){
			var editorimg_gallery_open=true;
			// 编辑器画廊
			$(".met-editor").each(function(){
				if($("img",this).length && !$(this).hasClass('no-gallery')){
					// 图片画廊参数设置
					var $self=$(this),
						imgsizeset=true;
					$("img",this).one('click',function(){
						var $img=$(this);
						if(imgsizeset){
							$self.find('img').each(function(){
	    						var src=$(this).attr('src'),
	    							size='';
	    						if($(this).data('width')){
	    							size=$(this).data('width')+'x'+$(this).data('height');
	    						}else if($(this).attr('width') && $(this).attr('height')){
	    							size=$(this).attr('width')+'x'+$(this).attr('height');
	    						}
								if(!($(this).parents('a').length && $(this).parents('a').find('img').length==1)) $(this).wrapAll('<a class="photoswipe-a"></a>');
								var $this_photoswipe_a=$(this).parents('.photoswipe-a');
								$this_photoswipe_a.attr({href:src,'data-med':src});
								if(size){
									$this_photoswipe_a.attr({'data-size':size,'data-med-size':size});
								}else{
									if($(this).data('original') && $(this).data('original')==$(this).attr('src')){
										var sizes=$(this)[0].naturalWidth+'x'+$(this)[0].naturalHeight;
										$this_photoswipe_a.attr({'data-size':sizes,'data-med-size':sizes});
									}
									$(this).imageloadFunAlone(function(imgs){
										var sizes=imgs.width+'x'+imgs.height;
										$this_photoswipe_a.attr({'data-size':sizes,'data-med-size':sizes});
									})
								}
			    			});
			    			imgsizeset=false;
						}
	    				if(editorimg_gallery_open){
		    				setTimeout(function(){
				    			$.initPhotoSwipeFromDOM('.met-editor','.photoswipe-a');//（需调用PhotoSwipe插件）
								editorimg_gallery_open=false;
								$img.click();
		    				},300);
		    			}
		    		});
				}
			});
		}
	});
})();