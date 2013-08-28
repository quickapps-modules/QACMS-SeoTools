var _TOKEN = '';
var _WORKING = false;

$(document).ready(function () {
	$('form input[type=submit]').click(function () {
		if (!_WORKING) {
			var form = $('#ToolAdminExecuteForm');
			$('div.processing').show();
			$('div.processing li img').attr('src', QuickApps.settings.base_url + 'seo_tools/img/icon-loading.gif');

			_WORKING = true;
			runTask('start', form.serialize());
		} else {
			alert(QuickApps.__t('Please be patient!'));
		}

		return false;
	});
});

function runTask(task, postData, callback) {
	var theData = typeof(postData) == 'string' ? postData + '&data[Tool][cmd]=' + task : 'data[Tool][cmd]=' + task;
	theData += _TOKEN ? '&data[Tool][token]=' + _TOKEN : '';

	$('div.processing .task-' + task + ' span').removeClass()
	.addClass('label')
	.addClass('label-info')
	.html(QuickApps.__t('Running'));

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

function taskDone(task) {
	$('div.processing .task-' + task + ' span').removeClass()
	.addClass('label')
	.addClass('label-success')
	.html(QuickApps.__t('Complete'));
}

function finalizeWork() {
	$('#ToolAdminExecuteForm').append('<input type="hidden" name="data[Tool][cmd]" id="CC_CMD" value="finalize" />');
	$('#ToolAdminExecuteForm').append('<input type="hidden" name="data[Tool][token]" value="' + _TOKEN + '" />');
	$('#ToolAdminExecuteForm').submit();		
}

function setToken(token) {
	_TOKEN = token;
}