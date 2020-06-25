{**
	* plugins/importexport/archivematica/templates/index.tpl
	*
	* List of operations this plugin can perform
	*}
	{include file="common/header.tpl" pageTitle="plugins.importexport.archivematica.displayName"}

	<script type="text/javascript"> 
	// Attach the JS file tab handler.
	{literal}
	$(function(){
		$('#exportTabs').pkpHandler('$.pkp.controllers.TabHandler');
		$('#exportTabs').tabs('option', 'cache', true);


		$(document).on("click", ".submitFormButton", function(e){
			 var pId = $(this).parent().parent().prop("id");
			if(pId == "issuesXmlForm"){
				var strCheck = '';
				if($(this).hasClass("submissionButton")){
					strCheck = 'selectedSubmissions';
				}else{
					strCheck = 'selectedIssues';
				}

				var checked = $('input[name=' + strCheck + '\\[\\]]').is(':checked');
				if(!checked){
					alert('{translate key="plugins.importexport.archivematica.selectCheckbox"}');
					e.preventDefault();
				}
			}

		});

		});
	{/literal}
	</script>

	<style type="text/css">
	{literal}
		.dot{
			height: 20px;
			width: 20px;
			border-radius: 50%;
			display: inline-block;	
		}

		.dot-available{
			border-radius: 20%;
			display: inline-block;
			text-align: center;
			background-color: #5ccad0;
			padding-left: 5px;
			padding-right: 5px;
		}

		.dot-deposited {
			background-color: #1bbb22;
		}

		.dot-expired {
			background-color: #ca1a1a;
		}


		.dot-not-all {
			background-color: #e89d12;
		}

		.dot-not-deposited {
			background-color: #ccc;
		}

		.info-aep{
			border-top: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			width: 250px;
			height: 120px;
			float: right;
			margin-top: -2em;	
		}

		.info-eap-li{
			display: flex;
		}
	{/literal}
	</style>

	<div id="exportTabs">
		<ul>
			<li><a href="#exportIssues-tab">{translate key="plugins.importexport.archivematica.exportIssues"}</a></li>
			<li><a href="#settings-tab">{translate key="plugins.importexport.archivematica.settings"}</a></li>
		</ul>

		<div id="exportIssues-tab">

			<script type="text/javascript">
			{literal}
				$(function(){
				// Attach the form handler.
				$('#exportIssuesXmlForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
				})
			{/literal};
			</script>
			<form id="exportIssuesXmlForm" class="pkp_form" action="{plugin_url path="exportSubmissions"}" method="post">
				{csrf}
				{fbvFormArea id="issuesXmlForm"}

				{assign var="issuesListGridUrl" value=$currentUrl|cat:"/getGrid/issues"}
				{load_url_in_div id="issuesListGridContainer" url=$issuesListGridUrl}

				<div class="info-aep">
					<ul>
						<li class="info-eap-li"><span class="dot dot-deposited"></span>&nbsp;&nbsp;{translate key="plugins.importexport.archivematica.preserved"}</li>
						<li class="info-eap-li"><span class="dot dot-not-all"></span>&nbsp;&nbsp;{translate key="plugins.importexport.archivematica.partiallyPreserved"}</li>
						<li class="info-eap-li"><span class="dot dot-not-deposited"></span>&nbsp;&nbsp;{translate key="plugins.importexport.archivematica.notPreserved"}</li>
					</ul>
				</div>

				{fbvFormButtons submitText="plugins.importexport.archivematica.exportIssues" hideCancel="true"}
				{/fbvFormArea}

			</form>
		</div>
		<div id="settings-tab">

			{assign var="settings" value=$currentUrl|cat:"/loadSettings"}
				{load_url_in_div id="settingsForm" url=$settings}

		</div>
	</div>

	{include file="common/footer.tpl"}
