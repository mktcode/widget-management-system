Social Media Pages
==================

Ein einfaches Tool um statische HTML-Templates mit dynamischen Widgets zu bestücken.

Grundsätzliche Funktionsweise
-----------------------------

Als Basis dient ein einfaches statisches HTML-Template. Dieses kann aus beliebig vielen Dateien und Unterverzeichnissen bestehen und auch PHP-Dateien enthalten, z.B. für den Versand von E-Mails über ein Kontaktformular.
Dabei ist lediglich zu beachten, dass PHP-Dateien vom System nicht beachtet werden und somit auch nicht über das Backend editierbar sind und auch nicht mit Widgets bestückt werden können.

Im Backend kann aus einer Auswahl von Widgets gewählt werden. (WYSIWYG, Facebook, Twitter, Instagram, etc.)
Die Einstellungsmöglichkeiten sind je nach Widget unterschiedlich. Ist ein Widget angelegt kann dieses mit dem zugehörigen Snippet (`<!--1234abcd...-->`) an einer beliebigen Stelle in einer HTML-Datei eingefügt werden.

Alle Anfragen an die HTML-Website werden über einen PHP-Frontcontroller geleitet, der dann die Snippets mit ihren jeweiligen dynamischen Inhalten austauscht.

Einrichtung
-----------

Die Einrichtung des Systems findet wie gewohnt über Git und Composer statt. Pro Website ist eine Installation nötig.
    
    git clone git@gitlab.intern.crea.de:kotti/social-media-pages.git
    composer install

Für die korrekte Funktionsweise ist nur eine simple ModRewrite-Anweisung nötig. Diese sollte nach möglichkeit direkt im Vhost eingetragen sein, um eine .htaccess-Datei im web-Verzeichnis zu vermeiden.
Die beiden Frontcontroller für das Backend und Frontend (`web/backend.php` und `web/frontend.php`) sollten der Übersichtlichkeit halber die einzigen beiden Dateien im Web-Verzeichnis bleiben.

    <VirtualHost *:80>
            ServerName website.tld
            DocumentRoot /path/to/web
            RewriteEngine on
            RewriteCond %{REQUEST_URI} !^/backend.php
            RewriteRule (.+)\.html$ /frontend.php [L]
    </VirtualHost>

Das `DocumentRoot` muss das web-Verzeichnis der Installation sein.

Neues Widget entwickeln
-------------------------

Um ein neues Widget (ContentType) zu entwickeln muss zunächst nur eine Klasse angelegt und als Service registriert werden.
Die Klasse muss von der abstrakten Elternklasse `App/ContentType/ContentType` erben. Hier werden einige Standardwerte vordefiniert, die dann in der eigenen Klasse überschrieben werden können.

`src/ContentType/FacebookLikeBox/FacebookLikeBox.php`

    <?php
    
    namespace App\ContentType\FacebookLikeBox;
    
    use App\ContentType\ContentType;
    
    class FacebookLikeBox extends ContentType
    {
    }

Nun muss die Klasse als Service definiert und mit dem Tag `content_type` versehen werden.

`config/services.yml`

    ...
    
    #####################
    ### Content Types ###
    #####################
    
    ...
    
    facebook_like_box:
        class: App\ContentType\FacebookLikeBox\FacebookLikeBox
        tags: [{name: content_type}]

Der neue ContentType ist somit bereits funktionsfähig. Im Backend können nun Widgets von diesem Typ angelegt werden.
Allerdings gibt es neben dem Feld für den internen Titel des Widgets noch keine weiteren Felder für etwaige Einstellungen des Widgets und auch keine Ausgabe im Frontend.

Für die weitere Ausgestaltung des neuen ContentTypes können die Methoden der Elternklasse `ContentType` überschrieben werden.

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

Diese Methode gibt das Label für den Button auf der Seite "Neuer Inhalt" zurück. Wird diese Methode nicht überschrieben wird der Name der Klasse zurückgegeben.

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

Hier kann eine Icon-Klasse von FontAwesome (https://fortawesome.github.io/Font-Awesome/) zurückgegeben werden. Es muss kein Prefix (`fa-` bzw. `uk-icon-`) angegeben werden.
Für das Icon http://fortawesome.github.io/Font-Awesome/icon/facebook-square/ reicht also z.B. nur `facebook-square`. Wird diese Methode nicht überschrieben wird kein Icon angezeigt.

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
    
Die Rückgabe dieser Methode kann eine oder mehrere CSS-Klassen enthalten, die dann dem Button auf der Seite "Neuer Inhalt" mitgegeben werden.
Wird diese Methode nicht überschrieben hat der Button nur die Klasse `uk-button`.
Da das Backend auf UI Kit (http://getuikit.com/) basiert, können hier natürlich sämtliche `uk-*`-Klassen verwendet werden.
Neue eigene Klassen können im `<head>`-Bereich in der `templates/header.php` definiert werden.


TODO
----

Kategorisierung von Inhalten
Caching
Twig Support
CodeMirror Syntax Highlighting je nach Datei
Analytics Block
Meta Tags
Robots.txt
Session Service implementieren (für flash messages etc.)