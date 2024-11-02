Anmeldedaten: c@c.de, pw: 12312313

Aufgabenblatt 6:



zusätzlich: DeleteUser auf der Profilsicht. Alle möglichen Error sind abgedeckt.
            Beim Erstellen von Rezepten wird ein Vorschaubild des neuen Bildes angezeigt. (Nachtrag zu Aufgabenblatt 5)




Aufgabenblatt 5:

    Features:
    - (JS+AJAX) Erweiterung der Startseite um Beiträge, die in einer Sammlung gespeichert werden. Bei jedem Klick auf "I want more Recipes" werden weitere Beiträge geladen.
    - (JS+AJAX) Beiträge können auf der viewRecipe-Seite durch einen Klick auf den jeweiligen Stern bewertet werden.
    - (JS)      Rezepte und Kommentare können nun nur nach einer Bestätigung gelöscht werden.

    Behobene Fehler der letzten Abgabe:
    - Beim Bearbeiten von Rezepten sind jetzt alle Felder mit den alten Daten voreingestellt (bspw. Meal type)
    - PHP-Fehlerausgabe (Uncaught MissingRecipeException bei viewRecipe.php?recipeID=232313) wurde gefangen und wird nun als Fehlermeldung ausgegeben. Ähnliche Fehler ebenfalls.
    - updateRecipe in recipeListPDOSQLite: es wird nun überprüft, ob der Nutzer die Berechtigung hat zu ändern
    - Diese vielen Scrollbars, die immer und fast überall erschienen sind, sind nun verschwunden.
    - HTML-Injections hier und dort wurden behoben.

    Nicht behoben (Designentscheidung):
    Im Menü gibt es den Eintrag "Create Recipe", obwohl ich nicht angemeldet bin. Klickt der unangemeldete Nutzer darauf, wird er auf die Login-Seite weitergeleitet (inklusive Nachricht).
    Das ist so gewollt, da ich es für sinnvoll halte, dass der Nutzer weiß, dass er sich anmelden muss, um ein Rezept zu erstellen und somit nicht lange suchen muss.
