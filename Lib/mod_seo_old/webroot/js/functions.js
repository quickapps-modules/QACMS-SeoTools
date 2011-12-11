function update_url(form){
		Messaging.hello(__("Processing..."), 1, false);
			new Ajax.Request ( 'mod_seo/urls/edit', {
									method: "post",
									parameters: form.serialize(),
									onSuccess: function(t){
										Messaging.hello(__('Processing...done'), 2, true);
									},
									onFailure: function (t){
										errorText = '<div align="left" style="margin:0 0 0 10px;" class="formErrors">'+t.responseText+'</div>';
										Messaging.window(errorText, 400, 0);
									}
								});
}


function chkAll(el) {
	chkAllByClassName(el, '');
}

function chkAllByClassName(el, className) {
	var className = className.blank() ? '' : '.' + className;
	if (el.checked==true){ c = true; } else { c = false; }
	$$( 'input[type="checkbox"]'+className).each(function(e){ if ( !e.hasClassName('text') ){ e.checked=c;} });/*fix do not check cfield checkboxes*/
}

function actions_select(selectObj){
		count_selected = 0;
		$$( 'input[type="checkbox"]' ).each(function(e){
			if ( e.checked == true && !isNaN(e.value) ){ count_selected = count_selected+1; }
		} );
		
		if ( parseInt(selectObj.value) != 0 && count_selected > 0){
		for(var i=0; i < selectObj.options.length; i++){
			if(selectObj.options[i].selected){
				selected = i;
			}
		}
		
		Messaging.confirm(__('Confirm this action: ')+selectObj.options[selected].getAttribute('text')+'?', "actions_select_exe('"+selectObj.value+"')");
	}
	selectObj.options[0].selected = true;
}

function actions_select_exe(action){
		var selected = "";
		$$( 'input[type="checkbox"]' ).each(function(e){
			if ( e.checked == true && !isNaN(e.value) ){ selected = selected+'&data[Items][id][]='+e.value; }
		} );
		
		if ( selected != "" ) {
		Messaging.hello(__("Processing..."), 1, false);
			new Ajax.Request	( base_url+'mod_lms/'+action, {
									method: "post",
									parameters: selected,
									evalScripts: true,
									onSuccess: function(t){
										try { $('items_list').innerHTML = t.responseText; } catch(e){}
										Messaging.hello(__('Processing...done'), 2, true);
									}
								});
		}
}

function open_tool(tool, window_width){
	Messaging.hello(__("Loading..."), 1, false);
	var window_width = window_width ? window_width : 900;
	new Ajax.Request	( base_url+'mod_seo/tools/'+tool, {
							method: 'get',
							onSuccess: function(t){
								Messaging.window(t.responseText, window_width);
							},
							onComplete: function (){
								Messaging.hello(__("Loading...done"), 1, true);
							}
	});
}

function tool_exe(window_width){
	Messaging.hello(__("Loading..."), 1, false);
	var window_width = window_width ? window_width : 900;
	var allNodes = Form.serialize($('toolForm'));
	new Ajax.Request ( $('toolForm').action, {
		method: 'post',
		parameters: allNodes,
		evalScripts: true, // doesnt work
		onSuccess: function(t){
			Messaging.window(t.responseText, window_width);
			if ( $('seo_chart') ){
				$('seo_chart').src = $F('chart_img_src');
	
				$('essential_passed_span').innerHTML = $F('essential_passed');
				$('essential_failed_span').innerHTML = $F('essential_failed');
				$('very_important_passed_span').innerHTML = $F('very_important_passed');
				$('very_important_failed_span').innerHTML = $F('very_important_failed');
				$('important_passed_span').innerHTML = $F('important_passed');
				$('important_failed_span').innerHTML = $F('important_failed');
				
				var count = 0;
				new PeriodicalExecuter(function(pe) {
					count = count+1;
					$$('img.competitor_tn').each(
						function(e){
							e.src = e.src.split('nocache=')[0] + 'nocache=' + Math.floor(Math.random()*11);
						}
					);
					
					if ( count > 3 )
						pe.stop();			
				}, 10);

			}
		},
		onFailure: function (t){
			Messaging.kill();
			errorText = '<div align="left" style="margin:0 0 0 10px;" class="formErrors">'+t.responseText+'</div>';
			Messaging.window(errorText, 400, 0);
		}
	});
}