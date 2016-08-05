# Widget Management System

Widget Management System is a simple tool to extend static HTML pages with dynamic widgets.

## Basic functionality

The basis is a plain old static html template with css and js and so on. It can consist of as many files and subdirectories you want and you are basically free to do what ever your want with it.
It can also contain php files, e.g. for sending forms etc., although php files are ignored in the backends file editor. This menas you cannot add widgets to php files... because you won't need to. ;-) 

You can choose from a variety of widgets you want to add to your html template. (WYSIWYG, Facebook, Twitter, Instagram, etc.)
Once you created a widget you can add it to your template just by pasting its snippet code, either by editing the file via ftp or whatever you like or using the backends integrated file editor.

All requests to your website will be processed by a single php frontcontroller, which then replaces the snippets with their actual content.

## Installation

First of all make sure your **php verison** is **5.4** or higher and you have **mod_rewrite** installed and enabled on your server.

Just download the pre-packaged archive and extract it to your server.

**IMPORTANT**: The archive contains a directory named `web`. The `DocumentRoot` of your website has to point to this directory and **not** to the main directory you donwloaded.
This is an important, security related best practice to protect all system related php files from public access.

To **access the backend** call `http://your-website.com/backend.php`.

### Config

Configure your database connection and other settings in `config/config.yml`. In there you will find the following config parameters:

**page.title** website title, only displayed in the backends menu bar *(default: Widgetized Website)*

**backend.title** title of the backend, displayed on the login screen and in the backends menu bar *(default: Widget Management System)*

**backend.bg** background color for login screen and backend menu bar *(default: #069865)*
        
**backend.color** text color for login screen and backend menu bar *(default: '#fff')*

**db.host** your database host *(default: localhost)*
        
**db.user** your database username *(default: root)*
        
**db.pass** your database password *(default: root)*

**db.name** your database name *(default: wms)*
        
**cache.lifetime** seconds cached files are valid before getting regenerated, set to 0 to disable caching *(default: 3600)*

**locale** backend language, currently supported values are en, de and es *(default: en)*

**demo** demo mode, shows default account data on login screen *(default: 0)*

### .htaccess

For the system to work properly you have to make sure that the file `/web/.htaccess` is uploaded to your server.

It maps all the requests to your website to a php frontcontroller and optionally improves the way your urls look like by removing the `.html` extension. (See comments in `/web/.htaccess` for more information.)

### Users

Backend users are configured in `/config/users.yml`. Each user is declared by its username followed by an md5 hash of the password an the role.

    admin: # username
        password: 21232f297a57a5a743894a0e4a801fc3 # password as md5 hash
        role: admin # role
    
    john:
        password: 5aee9dbd2a188839105073571bee1b1f
        role: editor

While an admin can create, edit and delete content widgets and edit the template files via the backend, an editor can only edit existing content widgets.

By default there is one admin and one editor account.

    Username: admin
    Password: admin
    
    Username: editor
    Password: editor

### Git & Composer

You can also install Widget Management System with git and composer.
    
    # switch to your project directory, e.g.:
    cd /srv/www/vhosts/your-website/httpdocs
    
    # clone the repository from gitlab
    git clone git@gitlab.com:mktcode/widget-management-system.git .
    
    # alternatively clone via https
    git clone https://gitlab.com/mktcode/widget-management-system.git .
    
    # and install the php dependencies with composer
    composer install

## Development

To develop a new widget (ContentType) you have to create a class and register it as a service.
The class musst extend from the abstract parent class `App/ContentType/ContentType`. Here some default values are defined which can then be overwritten in your own class. 

A minimum widget class looks like this:

`src/ContentType/FacebookLikeBox/FacebookLikeBox.php`
    
    <?php
    
    namespace App\ContentType\FacebookLikeBox;
    
    use App\ContentType\ContentType;
    
    class FacebookLikeBox extends ContentType
    {
    }

Now the class has to be registered as a service with a tag called `content_type`.

`config/services.yml`

    ...
    
    #####################
    ### Content Types ###
    #####################
    
    ...
    
    facebook_like_box:
        class: App\ContentType\FacebookLikeBox\FacebookLikeBox
        tags: [{name: content_type}]

The new Widget is now working. You can now create widgets of that new type.

However besides the field for the internal title of the widget there are no other fields to give the widget some content. So in the frontend there won't be any output so far.

To further define the functionality of your widget you can override the methods of the parent class `ContentType`.

**getLabel**
    
    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return array_pop(explode('\\', get_class($this)));
    }

This Methods returns the button label for the "New Widget" page. Default is the class name of your widget.

**getIcon**

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return '';
    }

Here you can return an fontawesome icon (https://fortawesome.github.io/Font-Awesome/). Use just the name of the icon without any prefix like `fa-` or `uk-icon-`.
For a facebook icon you would just return 'facebook'. if you don't override this method no icon will be displayed.

**getButtonClasses**

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return '';
    }
    
The return value of this method are css classes which are applied to the button, in addition to the default `uk-button` class.
The backends UI is based on the css framework UIKit (http://getuikit.com/) so you can of course use alle its classes.
Your own css classes can be defined in the `<head>` section in the template `templates/header.php`.

## Ideas

twig support
codemirror syntax highlighting depending on file type
more blocks
readable snippet-tags based on title/category
support for meta tags
default robots.txt
import/export
system reset
tutorial tour
google fonts in tiny mce