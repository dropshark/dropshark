INTRODUCTION
------------

The DropShark module integrates your Drupal site with the DropShark monitoring,
trending, and alerts service.

CONTENTS
--------

 * Installation
 * Linfo PHP Library
 * Troubleshooting
 * Maintainers

INSTALLATION
------------

Install the module per the normal Drupal module installation procedure. See
https://drupal.org/documentation/install/modules-themes/modules-7 for further
information.

Once installed go to

LINFO PHP LIBRARY
-----------------

You will likely want to install the Linfo library to collect additional server
data. See https://github.com/jrgp/linfo.

Installing Linfo can be done by either of the following means:

 * Use the Composer Manager project
   (https://www.drupal.org/project/composer_manager) to manage the installation.

 * Install using the dropshark.make file included with the DropShark module.

 * Download and install v3.0.0 into your libraries folder so that the
   standalone_autoload.php file is located at
   sites/all/libraries/linfo/standalone_autoload.php.


TROUBLESHOOTING
---------------

Please report bugs, issues, and feature requests in the Drupal.org issue queue
at https://www.drupal.org/project/issues/dropshark?categories=All.

Additionally you may contact DropShark support at help@dropshark.io.

MAINTAINERS
-----------

Current maintainers:

 * Will Long (https://www.drupal.org/u/kerasai)