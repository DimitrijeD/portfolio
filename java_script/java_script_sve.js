if ( window.history.replaceState ) 
{
	window.history.replaceState( null, null, window.location.href );
}
	// document.getElementById('0rec_sa_spiska').style.backgroundColor = "#000000";

class Aktivno_polje
{
	constructor()
	{
		this.id_aktivnog_polja = null;

		// b0cfcf - normalna boja
		this.normal_b = '#b0cfcf';

		// 81b1b1 - zatamnjena, resena polja (rec je pronadjena u osm)
		this.resena_b = '#81b1b1';
		
		// ff8080 - crvena - aktivna - korisnik je kliknuo na polje, 
		// i ceka se da klikne na drugo polje kako bi se proverilo da li taj put formira validnu rec sa spiska
		this.aktivna_b = '#ff8080';
	}

	postavi_aktivno_polje(polje)
	{
		this.id_aktivnog_polja = polje;
	}

	vrati_aktivno_polje()
	{
		return this.id_aktivnog_polja;
	}

	// ako je u klasi Resavanje_osmosmerke, i prvo i drugo polje null, onda mogu da aktiviram polje (crvena boja)
	aktiviraj_polje()
	{
		document.getElementById(this.id_aktivnog_polja).style.backgroundColor = this.aktivna_b;			
	}
	deaktiviraj_polje()
	{
		// ako je korisnik vec pronasao rec, onda se mora proveriti kojom bojom obojiti polje, normalnom ili resenom
		if(pronadjene_reci_obj.vrati_niz_pronadjenih_polja().includes(this.id_aktivnog_polja))
		{
			document.getElementById(this.id_aktivnog_polja).style.backgroundColor = this.resena_b;
		} else {
			document.getElementById(this.id_aktivnog_polja).style.backgroundColor = this.normal_b;
		}
		this.postavi_aktivno_polje(null);
	}

}

	//sve_reci_koje_prolaze_kroz_polje
class Highlight
{
	constructor(unete_reci)
	{
		console.log(unete_reci);
		this.unete_reci = unete_reci;
		this.normal_b = '#b0cfcf';
		this.aktivna_b = '#ff8080';
		this.aktivna_polja = [];
		
	}
	prikazi_sve_puteve(polje)
	{
		var polje_niz = [];
		polje_niz = split_id(polje);

		for(let i = 0; i < this.unete_reci.length; i++)
		{
			for(let j = 0; j < this.unete_reci[i][1].length; j++ )
			{
				if(polje_niz[0] == this.unete_reci[i][1][j][0] && polje_niz[1] == this.unete_reci[i][1][j][1])
				{	

					// onda treba da oboji sva polja odredjene reci
					for(let z = 0; z < this.unete_reci[i][1].length; z++)
					{					
						var polje_reci = unite_id(this.unete_reci[i][1][z]);
						
						var element = document.getElementById(polje_reci);
						// console.log(element);
						document.getElementById(polje_reci).style.backgroundColor = this.aktivna_b;
						this.aktivna_polja.push(polje_reci);
					}
				}
			}
		}			
	}
	vrati_normalno_stanje()
	{
		for(let i = 0; i < this.aktivna_polja.length; i++)
		{
			document.getElementById(this.aktivna_polja[i]).style.backgroundColor = this.normal_b;				
			//console.log(this.aktivna_polja);
		}
		this.aktivna_polja = [];
		
	}
}

class Pronadjene_reci
{
	constructor()
	{
		this.niz_pronadjenih_polja = [];
		// 81b1b1 - zatamnjena, resena polja (rec je pronadjena u osm)
		this.resena_b = '#81b1b1';
	}
	oboj_pronadjeno_polje(polje)
	{
		//unite_id(niz_id)
		document.getElementById(polje).style.backgroundColor = this.resena_b;

	}
	// put u smislu grana u grafu, niz polja, itd, objasnjeno u php-u
	oboj_ceo_put(niz_put)
	{
		var br_polja = 0;
		var id_polja_str = "";
		// console.log(niz_put);
		br_polja = niz_put.length;
		for(let i = 0; i < br_polja; i++)
		{
			// napravi string id-ja od [red, kolona] formata
			id_polja_str = unite_id(niz_put[i]);
			this.oboj_pronadjeno_polje(id_polja_str);
			this.niz_pronadjenih_polja.push(id_polja_str);
		}
	}
	vrati_niz_pronadjenih_polja()
	{
		return this.niz_pronadjenih_polja;
	}

}

class Resavanje_osmosmerke 
{
	// _k_   -  kliknuto polje
	constructor(prvo_k_polje, drugo_k_polje, sve_unete_reci) 
	{
	    this.prvo_k_polje = prvo_k_polje;
	    this.drugo_k_polje = drugo_k_polje;
	    this.sve_unete_reci = sve_unete_reci;
	    this.preostale_reci = sve_unete_reci;
	    this.br_unetih_reci = sve_unete_reci.length; 
	    this.br_preostalih_reci = sve_unete_reci.length;

	    this.da_li_su_sve_reci_pronadjene = false;
	}
	// --------------------------------------------------------------------------------------------------
	postavi_prvo_k_polje(novo_prvo_polje)
	{
		this.prvo_k_polje = novo_prvo_polje;
	}
	// -----------------------------------------------------
	postavi_drugo_k_polje(novo_drugo_polje)
	{
		this.drugo_k_polje = novo_drugo_polje;
	}
	// --------------------------------------------------------------------------------------------------
	vrati_prvo_k_polje()
	{
		return this.prvo_k_polje;
	}
	// -----------------------------------------------------
	vrati_drugo_k_polje()
	{
		return this.drugo_k_polje;		
	}
	// --------------------------------------------------------------------------------------------------
	vrati_br_unetih_reci()
	{
		return this.br_unetih_reci;
	}
	// --------------------------------------------------------------------------------------------------
	vrati_da_li_su_sve_reci_pronadjene()
	{
		return this.da_li_su_sve_reci_pronadjene;
	}
	// postavi_da_li_su_sve_reci_pronadjene()
	// {
	// 	this.da_li_su_sve_reci_pronadjene = true;
	// }
	sakrij_rec(rec) {
		var id_ = rec + "rec_sa_spiska";
		var id_reci = document.getElementById(id_); // "myDIV"
		// console.log(id_reci);
		// if (id_reci.style.display === "none") 
		// {
		// 	id_reci.style.display = "block";
		// } else {
			id_reci.style.display = "none";
		// }
	}	
	// --------------------------------------------------------------------------------------------------
	// rec je pronadjena u osmosmerci, znaci da se iz niza preostale_reci, uklanja ta pronadjena rec
	// i dodatno boji rec sa spiska (na ekranu) kao indikator da je rec pronadjena
	ukloni_pronadjenu_rec(i)
	{	
		if (i > -1) 
		{
			this.sakrij_rec(this.preostale_reci[i][0]);
			this.preostale_reci.splice(i, 1);
		} else {
			// GRESKA!
			console.log("GRESKA");
		}
	}
	// --------------------------------------------------------------------------------------------------
	selektovana_rec(prvo_polje, drugo_polje)
	{
		var duzina_puta = 0;
		// console.log(this.preostale_reci[0]);
		for(let i = 0; i < this.br_preostalih_reci; i++)
		{		
			duzina_puta = this.preostale_reci[i][1].length - 1;
			if ( (  this.preostale_reci[i][1][0][0] == prvo_polje[0] && this.preostale_reci[i][1][0][1] == prvo_polje[1] )
				 && 
				 (  this.preostale_reci[i][1][ duzina_puta ][0] == drugo_polje[0] 
				 && this.preostale_reci[i][1][ duzina_puta ][1] == drugo_polje[1] ) )
			{
				// console.log(this.preostale_reci[i]);
				// ovaj element i u nizu preostalih reci je ispravno pronadjena rec u osmosmerci, treba da se ukloni iz niza i restartuju kljucevi,
				// azurira brojac preostalih reci 
				// i da se precrta ili samo "posivi" na ekranu sa spiska kako bi korisnik znao da je pronasao ispravnu rec
				// takodje trebaju da se nulliraju vrednosti polja kako bi se oslobodio prostor za sledecu pretragu
				pronadjene_reci_obj.oboj_ceo_put(this.preostale_reci[i][1]);
				// console.log(this.preostale_reci[i][1]);
				// console.log(i);
				this.ukloni_pronadjenu_rec(i);
				this.postavi_prvo_k_polje(null);
				this.postavi_drugo_k_polje(null);
				this.azuriraj_br_preostalih_reci();

				if(this.preostale_reci.length === 0)
				{
					// console.log("PRAZAN JE");
					this.da_li_su_sve_reci_pronadjene = true;
				}
				
				
				// console.log(this.vrati_prvo_k_polje());
				// console.log(this.vrati_drugo_k_polje());
				// console.log(this.br_preostalih_reci);
				// console.log(this.preostale_reci);
				// return this.preostale_reci[i];					
			}				
		}
		// console.log("nije pronadjena ispravna rec");
		// nije pronadjena ispravna rec, treba da se restartuju podaci na pocetne vrednosti
		this.postavi_prvo_k_polje(null);
		this.postavi_drugo_k_polje(null);
		// return false;
	}
	// --------------------------------------------------------------------------------------------------
	azuriraj_br_preostalih_reci()
	{
		this.br_preostalih_reci = this.preostale_reci.length;
	}
	// --------------------------------------------------------------------------------------------------
}

class Konacno_resenje
{
	constructor(resenje)
	{
		this.resenje_osmosmerke = resenje;
		
	}
	// --------------------------------------------------------------------------------------------------
	/*		
	da_li_ima_resenje()
	{
		if(this.resenje_osmosmerke == "/")
		{
			// osmosmerka nema resenje, nakon sto su pronadjene sve reci, podaci se salju u bazu
			// return true;
		} else {
			// IMA resenje, treba da se napravi input za resenje koje se proverava da li je tacno
			
		}
	}
	*/
	// --------------------------------------------------------------------------------------------------
	provera_resenja() 
	{
		// resavanje_osmosmerke_obj.postavi_da_li_su_sve_reci_pronadjene();
		var korisnik_resenje = document.getElementById('resenje').value;
		// var korisnik_resenje = document.forms["forma_za_resenje"]["resenje"].value;
		// alert(popunjavanje_sa_korisnickim_recimaesenje); 
		// console.log(resavanje_osmosmerke_obj.vrati_da_li_su_sve_reci_pronadjene());
		// console.log(typeof(korisnik_resenje)); 
		if(resavanje_osmosmerke_obj.vrati_da_li_su_sve_reci_pronadjene())
		{
			// console.log("asdasdasdasd");
			// sve reci su pronadjene, korisnik mora uneti tacno resenje
			if(korisnik_resenje == this.resenje_osmosmerke)
			{
				console.log("TACNO RESENJE");
				// uneto je tacno resenje, salji se u bazu
				alert("ТАЧНО РЕШЕЊЕ!"); 
			} else {
				// nije uneto tacno resenje
				alert("Решење мора бити тачно уписано!"); 
				return false;
			}
		}

		if (korisnik_resenje == "") 
		{
			alert("Решење мора бити попуњено!"); 
			return false;
		}
	}
	// --------------------------------------------------------------------------------------------------
	preuzmi_vrednost_iz_forme_resenje()
	{
		// var korsnik_resenje = document.getElementById("input_resenje").value;
	}
	// --------------------------------------------------------------------------------------------------
	da_li_je_tacan_odogovor(user_string)
	{
		if(user_string == this.resenje_osmosmerke)
		{
			// kraj, salji podatke u bazu
			return true;
		} else {
			// upisan je netacan odgovor
			return false;
		}
	}
	// --------------------------------------------------------------------------------------------------
	// --------------------------------------------------------------------------------------------------
	
}

function kliknuto_polje(kliknut_id)
{	

	// kliknut_id  = "red/kolona"
	// kliknut_id_ = [int red, int kolona] 
	kliknuto_polje_ = split_id(kliknut_id);

	if(resavanje_osmosmerke_obj.vrati_da_li_su_sve_reci_pronadjene() == true)
	{			
		aktivno_polje_obj.postavi_aktivno_polje(kliknut_id);	
		aktivno_polje_obj.aktiviraj_polje();
	}
	

	// provera da se ne desava da vise polja bude "aktivirano" bojom
	if(aktivno_polje_obj.vrati_aktivno_polje() == null)
	{
		aktivno_polje_obj.postavi_aktivno_polje(kliknut_id);	
		aktivno_polje_obj.aktiviraj_polje();
	} else {
		aktivno_polje_obj.deaktiviraj_polje();
	}
	// sad dolazi rad sa klasom Resavanje_osmosmerke u kojoj se cuva vrednost prethodno kliknutog polja

	if(Array.isArray(kliknuto_polje_) && kliknuto_polje_.length == 2)
	{
		// polje koje je kliknuto ima [0=> red, 1=> kolona] strukturu sto znaci da svi ostali HTML tagovi u fajlovima ne smeju imati takvu strukturu 
		// niti atribut poziva ove funkcije u sebi
		// dalje se proverava da li je je vec ranije kliknuto drugo slovo ili nije
		if(resavanje_osmosmerke_obj.vrati_prvo_k_polje() == null)
		{	
			//znaci da je ovo prvo kliknuto slovo u osmosmerci i moze da se unese u objekat vrednost kliknuto_polje_
			resavanje_osmosmerke_obj.postavi_prvo_k_polje(kliknuto_polje_);
			
			// console.log( resavanje_osmosmerke_obj.vrati_prvo_k_polje() );
			// console.log( resavanje_osmosmerke_obj.vrati_drugo_k_polje() );
		} else if( resavanje_osmosmerke_obj.vrati_drugo_k_polje() == null)
		{
			//znaci da je ovo DRUGO kliknuto slovo u osmosmerci i moze da se unese u objekat vrednost kliknuto_polje_ i da se proveri da li je 
			// to ispravna reč u osmosmerci
			resavanje_osmosmerke_obj.postavi_drugo_k_polje( kliknuto_polje_ );
			resavanje_osmosmerke_obj.selektovana_rec(resavanje_osmosmerke_obj.vrati_prvo_k_polje(), resavanje_osmosmerke_obj.vrati_drugo_k_polje());
		}

	} else {
		// doslo je do verovatno fatalne greske nznm
	}	
}

// --------------------------------------------------------------------------------------------------
// pametnije bi bilo da sam sacuvao ove podatke u zasebnom objektu...
// funkcija primi string id-ja u formatu "red/kolona" i vraca niz [int red, int kolona] 
function split_id(id)
{
	var splitovan_id = id.split("/");
	splitovan_id[0] = parseInt(splitovan_id[0]);
	splitovan_id[1] = parseInt(splitovan_id[1]);
	return splitovan_id;
}

// funkcija primi niz [int red, int kolona] i vraca string id-ja u formatu "red/kolona"
function unite_id(niz_id)
{
	var string_id = niz_id[0] + "/" + niz_id[1];
	return string_id;
}
// --------------------------------------------------------------------------------------------------

function popuni_osmosmerku(instancirana_tablica, osmosmerka_obj, red, kolona)
{
	for(let r = 1; r <= red; r++)
	{
		for(let k = 1; k <= kolona; k++)
		{
			instancirana_tablica[r][k] = osmosmerka_obj[r][k];
		}
	}
	return instancirana_tablica;
}	

function instanciraj_tablicu(r, k) 
{
    osmosmerka_niz = [];
    for (var i = 1; i <= r; i++) 
    {
        var arr = []; // red
        osmosmerka_niz[i] = arr;

        for (var j = 1; j <= k; j++) 
        {
           osmosmerka_niz[i][j] = null; 
        }
    }
    // osmosmerka_niz[3][2] = "asdasd";
    return osmosmerka_niz;
}					

// -----------------------------------------------------------------------------------------------------------------------------------------------------//
// -----------------------------------------------------------------------------------------------------------------------------------------------------//
// -----------------------------------------------------------------------------------------------------------------------------------------------------//
// -------------------------------------------- Pravljenje asimetricnih osmosmerki ---------------------------------------------------------------------//
// -----------------------------------------------------------------------------------------------------------------------------------------------------//
// -----------------------------------------------------------------------------------------------------------------------------------------------------/  

	
function napravi_novu_tablicu()
{  
	var red=document.getElementById("red").value; 
	var kolona=document.getElementById("kolona").value;  

	red = parseInt(red);
	kolona = parseInt(kolona);

	Odabrana_polja_asm_osm_obj.postavi_red(red);
	Odabrana_polja_asm_osm_obj.postavi_kolonu(kolona);

	var tablica = instanciraj_tablicu_asimetricna(red, kolona);
}

function instanciraj_tablicu_asimetricna(r, k) 
{
    osmosmerka_niz = [];
    for (var i = 1; i <= r; i++) 
    {
        var arr = []; // red
        osmosmerka_niz[i] = arr;

        var red = document.createElement("tr");
        red.id = ''+i;
		document.getElementById("asimetricna_osm").appendChild(red);

        for (var j = 1; j <= k; j++) 
        {
			osmosmerka_niz[i][j] = null; 
			var polje = document.createElement("td");
			polje.id = i+'/'+j; 
			var tekst_polja = document.createTextNode("");
			polje.appendChild(tekst_polja);

			polje.onclick = function() {
				Odabrana_polja_asm_osm_obj.kliknuto_polje_asm(this.id);
			};

			document.getElementById(red.id).appendChild(polje);
			polje.style.backgroundColor = '#ff8080';
        }
    }
    return osmosmerka_niz;
}	

// podrazumeva se da je svako polje dozvoljeno za pravljenje asm osmosmerke, tako da uklanjanjem polja, se cuva u objektu
// isto tako ako korisnik pogresi moze opet da klikne na "deaktivirano" polje kako bi se to polje koristilo u osm
// dakle, u klasi stoje samo DEAKTIVIRANA POLJA

// dati PHP klasi Osmosmerka_templejt, i da se u njoj napravi metoda koja 
// prolazi kroz svaki od deaktiviranih polja i drugi loop prolazi kroz svaki put i treci kroz svako polje, i ako je jednako deaktiviranom polju
// brise ceo put, i prelazi na sledeci
// konacni niz treba da se pomeri u levo (jer su kljucevi poremeceni i klasa Osmosmerka ce da baguje) ko zna kako bice veselo
// u obe php klase treba da se stavi dodatni kod za rad sa asimetricnim osmosmerkama
class Odabrana_polja_asm_osm
{
	constructor()
	{
		this.deaktivirana_polja = [];

		this.normal_b = '#b0cfcf'; // blue
		this.aktivna_b = '#ff8080'; // red
	}	
	// -----------------------------------------------------------------------------------------------------------	
	kliknuto_polje_asm(id_str)
	{
		if(id_str)
		
		var n = this.deaktivirana_polja.includes(id_str);
		// ako nije u nizu
		if(n)
		{
			// polje je ranije deaktivirano ali je opet klikut na njega, dakle treba da se aktivira (red) i ukloni iz niza
			var index = this.deaktivirana_polja.indexOf(id_str);
			this.deaktivirana_polja.splice(index, 1);
					
			this.aktiviraj_polje(id_str);
		} else {
			// polje moze da se deaktivira i vrati boja na normalno (blue)
			this.deaktivirana_polja.push(id_str);
			this.deaktiviraj_polje(id_str);
		}
	}

	// -----------------------------------------------------------------------------------------------------------
	aktiviraj_polje(id_str)
	{
		document.getElementById(id_str).style.backgroundColor = this.aktivna_b;
		this.konacno_stanje_niza();	
	}
	// ---------------------------------------------------------------
	postavi_red(red)
	{
		this.red = red;
	}
	postavi_kolonu(kolona)
	{
		this.kolona = kolona;
	}
	vrati_red()
	{
		return this.red;
	}
	vrati_kolonu()
	{
		return this.kolona;
	}
	// ---------------------------------------------------------------

	// -----------------------------------------------------------------------------------------------------------
	deaktiviraj_polje(id_str)
	{
		document.getElementById(id_str).style.backgroundColor = this.normal_b;
		this.konacno_stanje_niza();	
	}
	konacno_stanje_niza()
	{
		console.log(document.getElementById('red').value);
		document.getElementById('polja_asm_osm').value = JSON.stringify(this.deaktivirana_polja);
		document.getElementById('red_velicina_osmosmerke').value = JSON.stringify(this.red);
		document.getElementById('kolona_velicina_osmosmerke').value = JSON.stringify(this.kolona);

	}
	// -----------------------------------------------------------------------------------------------------------
}

// MORA OVDE KAKO BI BROW ZNAO KOJI OBJEKAT JE U PITANJU - just JS thing
let Odabrana_polja_asm_osm_obj = new Odabrana_polja_asm_osm();

