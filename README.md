EMBEDD
===================


Embedd è un plugin per october cms che permette di incorporare i contenuti da molti servizi web, è basato su https://github.com/oscarotero/Embed, pertanto si fa riferimento a quest'ultimo per la lista aggiornata dei servizi supportati.

--------------------


Installazione
-------------

Questo plugin è ancora in fase sperimantale, pertanto non è ancora possibile installarlo tramite il normale processo di installazione di October CMS.

 - per installare il pacchetto, vai nella cartella `plugins` dell'installazione di october e clona questo repository nella cartella `inerba/embedd`.
	 `git clone https://github.com/inerba/october-embedd.git inerba/embedd`

 - vai nella cartella appena creata: `inerba/embedd` e installa tutte le dipendenze con `composer install`

----------


Come si usa
-------------------

Il plugin fornisce un semplice componente **Embedd** che consente di incorporare un elemento in una pagina del cms e il form widget **embedd**

### Form Widget embedd
Per utilizzare questo form widget bisogna attuare qualche accorgimento:

 - il campo del database che ospiterà i dati del form widget deve essere di tipo TEXT e nel *Model* deve essere indicato come *jsonable* ` protected $jsonable = ['embedd'];`
 
 - nel file `fields.yaml` del model, oltre ad indicare `type:embedd` bisogna che lélemento faccia riferimento all'url dell'array che andremo a salvare 
	``` 	 
	'embed[url]':
		label: 'Contenuto incorporato'
	    span: full
	    type: embedd
	```
 - nel *Model* dovremo includere la classe **Embedd**

	```php 
	use Inerba\Embedd\Classes\Embedd;
	```
	e utilizzare il metodo *beforeSave()* come nell'esempio seguente:
	
	```php 
	public function beforeSave()
    {
        $Embedd = new Embedd();
		$info = $Embedd->retrieve($this->embedd['url']);
        $this->embedd = $info;

    }
	```
