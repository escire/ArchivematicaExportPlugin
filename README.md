# Archivematica Export plugin

This plugin allows you to export articles or full numbers from OJS to an installation of Archivematica preservation software.

## Requirements

This Plugin was tested on the following environment:

- PHP 7.0.33
- MySQL 5.7.29
- OJS 3.1.2.0
- Archivematica 1.9.2
- Ubuntu 16.04.6 LTS
- Fedora Repository 5.1


## Installation

### Prerequisites

Archivematica installation instructions:

```
https://www.archivematica.org/fr/docs/archivematica-1.7/admin-manual/installation-setup/installation/install-ubuntu/
```

Fedora repository installation instructions:

```
https://wiki.lyrasis.org/display/FEDORA51/First+Steps
```

Configure Fedora repository in Archivematica:

```
https://wiki.archivematica.org/Storage_Service#FEDORA_via_SWORD2
```

![](/templates/images/fedoraSpaceArchivematica.png)



Install Plugin:

- cd [ojs_installation]/plugins/importexport
- git clone https://github.com/escire/ArchivematicaExportPlugin.git
- Enable plugin on Admin page: Settings / Website / Plugins



## Configuration

Setting up the required fields on the Archivematica Plugin Form

![](/templates/images/ArchivematicaPluginSettings.png)

| Field                                | Description                                                  |
| ------------------------------------ | ------------------------------------------------------------ |
| URL of Archivematica storage service | URL of the Storage Serrvice including the port (http://myarchivematica:8000) |
| UUID of Storage Space                | Unique Id generated from the configured FEDORA Space via SWORD2 on the Archivematica |
| Username                             | Storage Service username                                     |
| Password                             | Storage Service password                                     |



## How to use

Now you can start transfers from OJS to the preservation system, Articles or Issues:

![](/templates/images//PluginExport.png)

------

## License

This software is released under the the [GNU General Public License][gpl-licence].

[gpl-licence]: LICENSE
