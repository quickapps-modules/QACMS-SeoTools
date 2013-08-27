var _TOKEN = '';

$(document).ready(function () {
	$('form input[type=submit]').click(function () {
		var form = $('#ToolAdminExecuteForm');
		$('div.processing').show();
		$('div.processing li img').attr('src', QuickApps.settings.base_url + 'seo_tools/img/icon-loading.gif');

		runTask('start', form.serialize());

		return false;
	});
});

function taskDone(task) {
	$('div.processing .task-' + task + ' img').attr('src', QuickApps.settings.base_url + 'seo_tools/img/icon-accept-icon.png');
}

function setToken(token) {
	_TOKEN = token;
}

function finalizeWork() {
	$('#ToolAdminExecuteForm').append('<input type="hidden" name="data[Tool][cmd]" id="CC_CMD" value="finalize" />');
	$('#ToolAdminExecuteForm').append('<input type="hidden" name="data[Tool][token]" value="' + _TOKEN + '" />');
	$('#ToolAdminExecuteForm').submit();		
}

function runTask(cmd, postData, callback) {
	var theData = typeof(postData) == 'string' ? postData + '&data[Tool][cmd]=' + cmd : 'data[Tool][cmd]=' + cmd;
	theData += _TOKEN ? '&data[Tool][token]=' + _TOKEN : '';

	$.ajax({
		type: 'POST',
		url: QuickApps.settings.base_url + 'admin/seo_tools/tools/execute/CompetitorCompare',
		data: theData,
		dataType: 'script'
	}).success(function (msg) {
		if (typeof(callback) == 'function') {
			callback(msg);
		}
	});
}