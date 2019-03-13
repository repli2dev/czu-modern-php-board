README
------

Toto je ukázkové cvičení k demonstrační či samostatné ukázce Moderního PHP.

Co je potřeba k samostatnému procvičování:

 - Nainstalované PHP alespoň ve verzi 7.1 s rozšířením `mysqli` nebo `pdo_mysql` (zjistíte spuštěním `php -i` z příkazové řádky a vyhledáním příslušných řetězců)
 - Přístupná MySQL databáze (ideálně ve verzi 5.5 a vyšší).
 - Prezentace, obzvláště její poslední část, která vysvětluje důležité konstrukce, které víceméně budete muset použít.
 
 
Rozchození
----------

1. Stažení tohoto repozitáře, ideálně pomocí `git clone https://github.com/repli2dev/czu-modern-php-board.git`, případně pokud nemáte `git`, použijte možnost `Download as ZIP` na
https://github.com/repli2dev/czu-modern-php-board.

2. Přejděte do adresáře `czu-modern-php-board` a otevře v něm terminál.

3. Nainstalování závislostí pomocí příkazu `php composer.phar install`

4. Nastavte oprávnění důležitým adresářům `chmod 777 temp log`

5. Vytvořte `App/Config/config.local.neon` s následujícím obsahem (nahraďte příslušné údaje vašimi):

```
parameters:

dbal:
    connection:
        host: 127.0.0.1
        user: root
        password: root
        dbname: czu-modern-php-board
```


6. Pomocí následujícího příkazu vytvoře lokální vývojový server: `php -S localhost:8080 -t www`.

7. Na adrese http://localhost:8080/adminer.php se přihlaste do databáze a importujte do ní obsah souboru `schema.sql`. To vytvoří uživatele `test` a `test2` s hesly stejnými jako jména.

8. Přistup ne http://localhost:8080, měli byste vidět úvodní stránku kostry naší ukázkové aplikace.


Jak postupovat
--------------

1. Nejprve vytvořte nový `PostPresenter` a v něm akci `actionNew` a příslušnou šablonu s nějakým obsahem.
2. Přidejte odkaz na úvodní stránku uživatelům, kteří jsou přihlášení (nezapomeňte také na kontrolu v příslušné kontrole jako kontrolu před přímým přístupem zadáním adresy.)
3. Vytvořte továrníčku na formulář se jménem `postForm` v `PostPresenter` s jedním skoro prázdným `onSuccess` callbackem. Uvnitř zatím jen zkontrolujte znovu zkontrolujte, že je uživatel přihlášen.

----------------------------

1. Vytvořte novou entitu `Post` mapující sloupce z tabulky `board_post`, autora vytvořte jako asociaci `ManyToOne`. 
2. Upravte callback `onSuccess` formuláře aby ukládal data do databáze, vyplnil aktuální datum, aktivnost příspěvku... (Tip: musíte si načíst entitu pro aktuálně uživatele, aby jste ji mohli předat do příspěvku.)

---------------------------

1. Přidejte do `HomepagePresenter` zobrazení všech příspěvků (seřazeno sestupně dle data vložení), vypište hlášku pokud žádné nebudou.
2. Pokud je přihlášen autor, zobrazte odkazy neaktivní/aktivní, smazat. (Budete muset vytvořit příslušné akce, aby se odkazy sestavily.)
3. Oživte obě akce - nezapomeňte na kontrolu oprávnění!


Řešení
------

Řešení naleznete ve stejném repozitáři pod různými tagy (přepíná se na GitHubu kliknutím na `Branch` vlevo nad soubory).


Dotazy
------

Máte-li problém s rozchozením či zápasíte s nějakým problémem při implementaci klidně napište na jan.drabek@trigama.eu.
