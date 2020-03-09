  <?php

  /**
   * @file ArchivematicaSettingsForm.inc.php
   *
   * @class ArchivematicaSettingsForm
   * @brief Form class for save settings
   */

  import('lib.pkp.classes.form.Form');
  class ArchivematicaSettingsForm extends Form {

    public $plugin;

    /**
     * Constructor
     * @param $plugin ArchivematicaExportPlugin
     */

    public function __construct($plugin) {
      parent::__construct($plugin->getTemplateResource('settings.tpl'));
      $this->plugin = $plugin;

      $this->addCheck(new FormValidatorPost($this));
      $this->addCheck(new FormValidatorCSRF($this));
      $this->addCheck(new FormValidatorUrl($this, 'ArchivematicaStorageServiceUrl', FORM_VALIDATOR_REQUIRED_VALUE, 'plugins.importexport.archivematica.invalidUrl'));
      $this->addCheck(new FormValidator($this, 'ArchivematicaStorageServiceSpaceUUID', FORM_VALIDATOR_REQUIRED_VALUE, 'plugins.importexport.archivematica.fieldRequired'));
      $this->addCheck(new FormValidator($this, 'ArchivematicaStorageServiceUser', FORM_VALIDATOR_REQUIRED_VALUE, 'plugins.importexport.archivematica.fieldRequired'));
      $this->addCheck(new FormValidator($this, 'ArchivematicaStorageServicePassword', FORM_VALIDATOR_REQUIRED_VALUE, 'plugins.importexport.archivematica.fieldRequired'));

    }


    /**
     * Asign content for each field
     */
    public function initData() {
      $contextId = $context = Request::getContext()->getId();
      $this->setData('ArchivematicaStorageServiceUrl', $this->plugin->getSetting($contextId, 'ArchivematicaStorageServiceUrl'));
      $this->setData('ArchivematicaStorageServiceSpaceUUID', $this->plugin->getSetting($contextId, 'ArchivematicaStorageServiceSpaceUUID'));
      $this->setData('ArchivematicaStorageServiceUser', $this->plugin->getSetting($contextId, 'ArchivematicaStorageServiceUser'));
      $this->setData('ArchivematicaStorageServicePassword', $this->plugin->getSetting($contextId, 'ArchivematicaStorageServicePassword'));
      parent::initData();
    }


    /**
     * Read input data from request
     */
    public function readInputData() {
      $this->readUserVars(['ArchivematicaStorageServiceUrl']);
      $this->readUserVars(['ArchivematicaStorageServiceSpaceUUID']);
      $this->readUserVars(['ArchivematicaStorageServiceUser']);
      $this->readUserVars(['ArchivematicaStorageServicePassword']);
      parent::readInputData();
    }


    /**
     * Display the form
     */
    public function fetch($request, $template = null, $display = false) {
      $templateMgr = TemplateManager::getManager($request);
      $templateMgr->assign('pluginName', $this->plugin->getName());
      return parent::fetch($request, $template, $display);
    }

    /**
     * Save settings
     */
    public function execute() {
      $contextId = $context = Request::getContext()->getId();
      $this->plugin->updateSetting($contextId, 'ArchivematicaStorageServiceUrl', $this->getData('ArchivematicaStorageServiceUrl'));
      $this->plugin->updateSetting($contextId, 'ArchivematicaStorageServiceSpaceUUID', $this->getData('ArchivematicaStorageServiceSpaceUUID'));
      $this->plugin->updateSetting($contextId, 'ArchivematicaStorageServiceUser', $this->getData('ArchivematicaStorageServiceUser'));
      $this->plugin->updateSetting($contextId, 'ArchivematicaStorageServicePassword', $this->getData('ArchivematicaStorageServicePassword'));


      import('classes.notification.NotificationManager');
      $notificationMgr = new NotificationManager();
      $notificationMgr->createTrivialNotification(
        Request::getUser()->getId(),
        NOTIFICATION_TYPE_SUCCESS,
        ['contents' => __('common.changesSaved')]
      );

      return parent::execute();
    }
  }