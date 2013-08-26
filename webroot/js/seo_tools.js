$(document).ready(function () {
	updateTitle();
	updateDescription();

	$('a.retrieve-page').click(function () {
		if ($('#SeoUrlUrl').val()) {
			$('a.retrieve-page img').attr('src', QuickApps.settings.base_url + 'seo_tools/img/icon-loading.gif');

			$.ajax({
				type: 'POST',
				url: QuickApps.settings.base_url + 'admin/seo_tools/urls/index',
				data: 'data[fetch_url]=' + $('#SeoUrlUrl').val()
			}).done(function(data) {
				$('#SeoUrlTitle').val(data.title);
				$('#SeoUrlDescription').val(data.description);
				$('#SeoUrlKeywords').val(data.keywords);

				if (data.title.length * data.url.length * data.description.length > 0) {
					updateSnippet();
				}

				$('a.retrieve-page img').attr('src', QuickApps.settings.base_url + 'seo_tools/img/icon-download.gif');
			});
		}

		return false;
	});

	$('#RedirectToggler').click(function () {
		if ($(this).is(':checked')) {
			$('div.nonredirect').hide();
			$('div.redirect-url-input').show();
			$('div.snippet-container').hide();
			$('a.retrieve-page').hide();
		} else {
			$('div.nonredirect').show();
			$('div.redirect-url-input').hide();

			if ($('#SeoUrlUrl').val()) {
				$('a.retrieve-page').show();
			}

			updateSnippet();
		}
	});

	$('#SeoUrlUrl').keyup(function() {
        if ($('#SeoUrlUrl').val()) {
			$('a.retrieve-page').show();
		} else {
			$('a.retrieve-page').hide();
		}
    });

	$('#SeoUrlTitle').keyup(function() {
        updateTitle();
    });

	$('#SeoUrlUrl').keyup(function() {
        updateSnippet();
    });

	$('#SeoUrlDescription').keyup(function() {
        updateDescription();
    });

	function updateTitle() {
		var title = $('#SeoUrlTitle').val();
		var diff = 70 - title.length;
		var diff_html = '';

		if (diff < 0) {
			diff_html = '<span style="color:red; font-weight:bold;">' + diff + '</span>';
		} else {
			diff_html = '<span style="color:green; font-weight:bold;">' + diff + '</span>';
		}

		$('span.title-chars-left').html(diff_html);
		updateSnippet();
	}

	function updateDescription() {
		var title = $('#SeoUrlDescription').val();
		var diff = 156 - title.length;
		var diff_html = '';

		if (diff < 0) {
			diff_html = '<span style="color:red; font-weight:bold;">' + diff + '</span>';
		} else {
			diff_html = '<span style="color:green; font-weight:bold;">' + diff + '</span>';
		}

		$('span.desc-chars-left').html(diff_html);
		updateSnippet();
	}

	function updateSnippet() {
		var title = truncateStr($('#SeoUrlTitle').val(), 70);
		var url = $('#SeoUrlUrl').val();
		var description = truncateStr($('#SeoUrlDescription').val(), 156);

		$('#preview-snippet .title').html(title);
		$('#preview-snippet span.url').html(url);
		$('#preview-snippet .description').html(description);
		
		if (title.length * url.length * description.length > 0) {
			$('div.snippet-container').show();
		} else {
			$('div.snippet-container').hide();
		}
	}

	function truncateStr(string, len) {
		if (string.length > len) {
			string = string.substring(0, len) + ' ...';
		}

		return string;
	}
});