------------------------------------------------------------------------------------------------------------------------------------

Anmeldedaten: c@c.de, pw: 12312313

------------------------------------------------------------------------------------------------------------------------------------

Finale Abgabe:

Nicht umgesetzt:
- Favoritenliste, da ich die Zeit nicht mehr hatte, um das zu implementieren. Die Funktionalität ist
  jedoch zumindest datenbankseitig zu Teilen vorhanden.


Designentscheidungen:
- Beim Erstellen von Rezepten kann ein Fehler auftreten. In diesem Fall werden alle Felder wieder mit den alten Daten voreingestellt.
  Nur das Bild muss erneut hochgeladen werden. Das ist so gewollt, da ich es für sinnvoll halte, dass der Nutzer das Bild noch einmal
  überprüfen kann, bevor er es hochlädt.

- Kommentare können nicht bearbeitet werden. Das ist so gewollt, da ich es für sinnvoll halte, dass der Nutzer sich überlegt, was er schreibt.
  Ein Kommentar kann jedoch gelöscht und neu geschrieben werden.


------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 6:


API auf Startseite zum Aufrufen eines zufälligen Rezepts. Dazu bestehen außerdem Filtermöglichkeiten.
    siehe hierzu getRandomRecipe.php

Datenschutz, Impressum und CO.
    Bestätigung der Datenschutzbestimmungen und AGBs bei der Registrierung.
    Bestätigung der Veröffentlichung von Rezepten und Bildern bei der Erstellung.
    Password-Hashing und -Salting.
    Identifizierung mittels E-Mail-Adresse und Passwort.

Cookie-Banner (include/cookies.php)
    Der Nutzer wird beim ersten Besuch der Seite aufgefordert, die Cookies zu akzeptieren.

Registrierung und Login
    Bei Registrierung wird ein File angelegt, welches einen Code beinhaltet, der im Folgenden eingegeben werden muss, um die Registrierung abzuschließen.
    Im Anschluss kann der Nutzer sich einloggen. In der Registrierung wird auch überprüft, ob der Account bereits aktiviert wurde. Ist dies der Fall, wird dies in
    die Datei geschrieben, andernfalls wird dem Nutzer ein neuer Code generiert.
    Beim LogIn mit einem nicht aktivierten Account wird lediglich die Information "Invalid login data. Please try again" ausgegeben
    (Datenschutz). Der Nutzer erhält daraufhin eine Mail (File), mit entsprechenden vertraulichen Informationen.

Passwort vergessen
    Der Nutzer kann sich ein neues Passwort an seine E-Mail-Adresse schicken lassen. Dazu wird ein Code generiert, der
    im Anschluss eingegeben werden muss, um das Passwort zu ändern. Im Formular werden bei einer Falscheingabe des neuen
    Passworts dabei bewusst keine Daten übertragen, um die Sicherheit zu erhöhen.
    Außerdem wird der Nutzer auch auf die Eingabe des Aktivierungscodes weitergeleitet, falls die E-Mail-Adresse nicht
    im System vorhanden ist. Andernfalls könnte ein Angreifer herausfinden, ob eine E-Mail-Adresse im System vorhanden ist.



zusätzlich: DeleteUser auf der Profilsicht. Alle möglichen Edge Cases sind abgedeckt.
            Beim Erstellen von Rezepten wird ein Vorschaubild des neuen Bildes angezeigt. (Nachtrag zu Aufgabenblatt 5)



------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 5:

    Features:
    - (JS+AJAX) Erweiterung der Startseite um Beiträge, die in einer Sammlung gespeichert werden. Bei jedem Klick auf "I want more Recipes" werden weitere Beiträge geladen.
    - (JS+AJAX) Beiträge können auf der viewRecipe-Seite durch einen Klick auf den jeweiligen Stern bewertet werden.
    - (JS)      Rezepte, Kommentare und der eigene Account können nun nur nach einer Bestätigung gelöscht werden.
    - (JS)      Beim Erstellen von Rezepten wird ein Vorschaubild des neuen Bildes angezeigt.

    Behobene Fehler der letzten Abgabe:
    - Beim Bearbeiten von Rezepten sind jetzt alle Felder mit den alten Daten voreingestellt (bspw. Meal type)
    - PHP-Fehlerausgabe (Uncaught MissingRecipeException bei viewRecipe.php?recipeID=232313) wurde gefangen und wird nun als Fehlermeldung ausgegeben. Ähnliche Fehler ebenfalls.
    - updateRecipe in recipeListPDOSQLite: es wird nun überprüft, ob der Nutzer die Berechtigung hat zu ändern
    - Diese vielen Scrollbars, die immer und fast überall erschienen sind, sind nun verschwunden.
    - HTML-Injections hier und dort wurden behoben.

    Nicht behoben (Designentscheidung):
    Im Menü gibt es den Eintrag "Create Recipe", obwohl ich nicht angemeldet bin. Klickt der unangemeldete Nutzer darauf, wird er auf die Login-Seite weitergeleitet (inklusive Nachricht).
    Das ist so gewollt, da ich es für sinnvoll halte, dass der Nutzer weiß, dass er sich anmelden muss, um ein Rezept zu erstellen und somit nicht lange suchen muss.


------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 4

    Features:
    - Speicherung von Daten mit SQLite3.
    - PDO-Implementierung für SQLite3.
    - Datenschema (siehe Planung) wurde umgesetzt.
    - Automatische Erstellung einer Datenbank, falls diese nicht vorhanden ist.
    - Transaktionen überall, wo es sinnvoll/nötig ist.
    - Prepared Statements zur Vermeidung von SQL-Injections.
    - Passwort-Hashing und -Salting.
    - Exception-Handling für alle möglichen Fehlerfälle.


------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 3

    Features:
    - Registrierung und Login
    - Logout
    - Profilseite
    - Rezept erstellen
    - Rezept bearbeiten
    - Rezept löschen
    - Kommentare schreiben
    - Kommentare löschen
    - Rezept bewerten
    - Rezept ansehen
    - Profil ansehen
    - Profil bearbeiten
    - Rezepte filtern
    - Zustandsspeicherung in Session


------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 2

    Features:
    - Optische Gestaltung der Website
    - Einsatz von CSS-Flexbox
    - Responsives Design
    - Farbgebung (wave-getestet)
    - Accessibility (wave-getestet)


------------------------------------------------------------------------------------------------------------------------------------

Aufgabenblatt 1

    Features:
    - Grundgerüst der Website
    - Navigation
    - Startseite mit Rezeptübersicht
    - Rezeptansicht
    - Profilseite
    - Login
    - Registrierung