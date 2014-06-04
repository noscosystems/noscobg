# New Project

This project is designed to kickstart a new Yii application through Composer
commands. It does not provide **any** functionality other than application structure.
Everything must be written from scratch; although several components, controllers, 
models and migrations are available upon request (for common functionality such as 
user authentication).

**Note:** This repository is based upon an outdated project that no longer has any open-source
releases.

This project utilises the following libraries, listed as Composer dependancies:

- [Yii Framework][yii]: a high-performance PHP framework best for developing Web 2.0
  applications.
- Twitter's [Bootstrap](http://getbootstrap.com "Bootstrap CSS Framework"): popular
  front-end framework for developing responsive, mobile first projects on the web.
- [PHPUnit](http://phpunit.de "PHPUnit Testing Framework"): a programmer-oriented 
  testing framework for PHP.



## License

This project is licensed under the [MIT/X11][mit] open-source license.



## Documentation

All current documentation for this project is within the source-code itself, as
comments or DocComments.



## Source Code

This project is kept under [Git][git] and is hosted on the [GitHub][github].
Source code can be accessed from `git@github.com:noscosystems/noscobg.git`.


### Installation

Create the file `application/config/databases.php` which returns an array of
environment-separated database credentials. For example:

    <?php
        return array(
            'develop' => array(
                'connectionString' => 'mysql:host=localhost;dbname=test',
                'username' => 'root',
                'password' => '',
            ),
            'production' => array(
                'connectionString' => 'mysql:host=localhost;dbname=longDatabaseName',
                'username' => 'accountName',
                'password' => 'supersecret',
                'tablePrefix' => 'app_'
            ),
        );

Next, place the name of your chosen environment inside
`application/config/.environment`. Then perform the database migration which
will upgrade your database to work with the application:

    $ cd "/path/to/project"
    $ ./application/yiic migrate

**Note:** This project has been built on the presumption that it will run on a
Linux server with [PHP 5.3+](http://www.php.net).



## Authors

- [Zander Baldwin][zander]; that super amazing guy that everyone loves.
- [Luchica Scowen](https://github.com/scowen); that funny guy who makes jokes all the time.
- [Clive Dann](https://github.com/clivedann); ... Clive.



## Contact

Please contact [Darsyn][darsyn] directly on the following details for bug
reports, feature requests, patch submissions, etc.:

<div class="vcard">
<div class="org">Nosco Systems</div>
<div class="adr">
<span class="street-address">5 High Street</span>,<br />
<span class="locality">Pontypridd</span>,
<span class="region">Rhondda Cynon Taf</span>,<br />
<span class="country-name">United Kingdom</span>.
<span class="postal-code">CF37 1QJ</span>.
</div>
</div>

---



## Database Guidelines

After you have set up your database credentials in `application.config.databases`,
all changes to the database that are not done through normal application
operations **must** be done through [database migrations][migrate] with the
`yiic` tool. This means any schema changes, and default data.

As a rule of thumb, until you are comfortable with database changes being done
this way, the use of [phpMyAdmin][phpmyadmin] is forbidden except as a reference
tool.

<!--
    Guidelines for a Successful README
    - Name of the projects and all sub-modules and libraries (sometimes they are
      named different and very confusing to new users).
    - Descriptions of all the project, and all sub-modules and libraries.
    - 5-line code snippet on how its used (if it's a library).
    - Copyright and licensing information (or "Read LICENSE").
    - Instruction to grab the documentation.
    - Instructions to install, configure, and to run the programs.
    - Instruction to grab the latest code and detailed instructions to build it
      (or quick overview and "Read INSTALL").
    - List of authors or "Read AUTHORS".
    - Instructions to submit bugs, feature requests, submit patches, join
      mailing list, get announcements, or join the user or dev community in
      other forms.
    - Other contact info (email address, website, company name, address, etc).
    - A brief history if it's a replacement or a fork of something else.
    - Legal notices (crypto stuff).
-->

[darsyn]: http://darsyn.co.uk "Darsyn Technologies, Ltd."
[yii]: http://www.yiiframework.com "Yii Framework"
[phpass]: http://rchouinard.github.io/phpass/ "PHPass: Password Library for PHP"
[phperian]: https://github.com/mynameiszanders/phperian "PHPerian on GitHub"
[phpseclib]: http://phpseclib.sourceforge.net "PHPSecLib on SourceForge"
[eula]: http://darsyn.co.uk/clients/eula "Darsyn: End User License Agreement for Clients"
[mit]: http://j.mp/mit-license "MIT/X11 Open-Source License"
[zander]: http://mynameis.zande.rs "Zander Baldwin"
[git]: http://git-scm.com "Git Version Control"
[github]: https://github.com "GitHub: Build software better, together."
[migrate]: http://yiiframework.com/doc/guide/en/database.migration "Database Migrations in Yii"
[phpmyadmin]: http://www.phpmyadmin.net/home_page/index.php "phpMyAdmin"
