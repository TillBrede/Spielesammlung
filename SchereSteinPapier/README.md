# SchereSteinPapier
Eine Möglichkeit Schere Stein Papier im WebFront zu spielen.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Schere Stein Papier in IP-Symcon

### 2. Voraussetzungen

- IP-Symcon ab Version 5.0

### 3. Software-Installation

* Über den Modul Store das Modul Spielesammlung installieren.
* Alternativ über das Modul Control folgende URL hinzufügen:
`https://github.com/TillBrede/Spielesammlung`  

### 4. Einrichten der Instanzen in IP-Symcon

- Unter "Instanz hinzufügen" ist das 'SchereSteinPapier'-Modul unter dem Hersteller '(Gerät)' aufgeführt.  

__Konfigurationsseite__:

Es gibt keine Einstellungsmöglichkeiten.

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Name            | Typ     | Beschreibung
--------------- | ------- | ----------------
Deine Wahl      | Integer | Wahl des Spielers.
Computer wählte | Integer | Zeigt die Wahl des Computers.
Ergebnis        | String  | Zeigt das Ergebnis.

##### Profile:

Name       | Typ
---------- | ------- 
SSP.Choice | Integer

### 6. WebFront

Hier wird gespielt.

### 7. PHP-Befehlsreferenz

Diese Modul hat keine eigenen Befehle.

