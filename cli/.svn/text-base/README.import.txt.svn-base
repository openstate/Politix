[sorry for my bad English]

To extract the data from politix.nl database:

 1) create local mysql database, import their dump
 2) using "DESCRIBE table" or PhpMyAdmin inspect the structure of the table
 3) edit politixExtract.php
  > set correct host/user/database for your local installation
  > change $voorstellen_table to the name of your table containing imported data
  > change $parties, add names of the columns representing vote by parties

Probably you won't need to change anything, however politix.nl tends to change their tables often.
Run:

  > php politixExtract.php

The script should dump the data to "import.{$voorstellen_table}.xml"


To import the data:

 > #dry run mode
 > php import.php import_file.xml
 
 > #if everything is OK
 > php import.php -c import_file.xml

The importer should end with "Done" without any error message.
Read more about import file syntax in README.import_file


Troubleshooting.

 - Check your privates/database.private.php if you can't connect to the database.
 - Check schema if some object of the schema can't be implicitly created (if extra info is required).
 - Mail me: ja.doma@gmail.com



Ensure following files are present:

 public_html/import.dtd
 public_html/import.xsd
 classes/utils/*Model.class.php and *ModelSchema.class.php
 modules/xml/pages/php/schemaAPage.class.php
 cli/import.php


The .dtd and .xsd files are great source of info about syntax of the import file.


The importer performs work in two stages:

 - merging the schema
 - inserting new raadsstukken

Therefore two sub-elements 'schema' and 'raadsstukken' are used. Both are optional, so you may synchronize the schema only.
Contents of both elements are extensively described in import.dtd and import.xsd files.

The schema definition is required if new raadsstukken refer to non-existing schema objects, these objects will then be
created on demand. Some objects are very simple, so they will be created implicitly (eg. tags, categories, regions etc).

The schema is:

 - regions
 - tags
 - categories
 - sites
 - parties
 - politicians

You can obtain current schema by {politix domain}/xml/schema
To obtain specific schema: {politix domain}/xml/schema/{regions, tags etc}


The code.

The importer is implemented as set of merge-model classes located in classes/utils/
The purpose of these classes is different than classes/records, they try to find
the existing record before inserting new one (merge-model). The schema objects
are protected from duplicates by these classes. 

The raadsstukken are not protected from duplicates, so running importer twice
will simply insert duplicate records.