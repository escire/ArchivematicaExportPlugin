<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#archivematicaSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="archivematicaSettingsForm" method="post" action="{plugin_url path="saveSettings"}" >


	{csrf}

	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="ArchivematicaSettingsFormNotification"}

  {fbvFormArea}

		{fbvFormSection}
		{fbvElement
        type="text"
        id="ArchivematicaStorageServiceUrl"
        value=$ArchivematicaStorageServiceUrl
        label="plugins.importexport.archivematica.ArchivematicaStorageServiceUrl"}


		{fbvElement
        type="text"
        id="ArchivematicaStorageServiceSpaceUUID"
        value=$ArchivematicaStorageServiceSpaceUUID
        label="plugins.importexport.archivematica.ArchivematicaStorageServiceSpaceUUID"}


		{fbvElement
        type="text"
        id="ArchivematicaStorageServiceUser"
        value=$ArchivematicaStorageServiceUser
        label="plugins.importexport.archivematica.ArchivematicaStorageServiceUser"}


		{fbvElement
        type="text"
        password="true"
        id="ArchivematicaStorageServicePassword"
        value=$ArchivematicaStorageServicePassword
        label="plugins.importexport.archivematica.ArchivematicaStorageServicePassword"}




		{/fbvFormSection}
  {/fbvFormArea}
	{fbvFormButtons submitText="common.save"}

</form>