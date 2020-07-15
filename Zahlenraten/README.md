# Zahlenraten
Ein kleines Spiel, bei dem eine zufällige Zahl erraten werden muss.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Ein kleines Spiel, bei dem eine zufällige Zahl erraten werden muss.

### 2. Voraussetzungen

- IP-Symcon ab Version 5.0

### 3. Software-Installation

* Über den Module Store das Modul Spielesammlung installieren.
* Alternativ über das Module Control folgende URL hinzufügen:
`https://github.com/TillBrede/Spielesammlung`  

### 4. Einrichten der Instanzen in IP-Symcon

- Unter "Instanz hinzufügen" kann das 'Zahlenraten'-Modul mithilfe der Schnellsuche einfach gefunden werden.  

__Konfigurationsseite__:

Name                          | Typ     | Beschreibung
----------------------------- | ------- | -------------------------------------
Minimum der generierten Zahl  | Integer | Das Minimum der Zahl die generiert wird.
Maximum der generierten Zahl  | Integer | Das Maximum der Zahl die generiert wird.
Anzahl der erlaubten Versuche | Integer | Die Anzahl der Versuche, die der Spieler zum Erraten der Zahl hat. 

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Name           | Typ     | Beschreibung
-------------- | ------- | --------------------------------
Züge übrig     | Integer | Zeigt die Anzahl der verbleibenden Versuche.
Deine Zahl ist | String  | Zeigt an ob der Tipp größer oder kleiner als die zu erratende Zahl ist.
Dein Tipp      | Integer | Das Eingabefeld für den Tipp des Spielers.

##### Profile:

Es werden keine neuen Profile erstellt.

### 6. WebFront

Hier wird gespielt.

### 7. PHP-Befehlsreferenz

`boolean ZR_Generate(integer $InstanzID);`
Generiert eine neue Zahl, die erraten werden kann.  
Beispiel:  
`ZR_Generate(12345);`

